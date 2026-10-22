<?php
declare(strict_types=1);

namespace EarthCycle\Controllers;

use EarthCycle\Repositories\FeedbackRepository;
use EarthCycle\Services\SecurityService;
use Throwable;

/**
 * EarthCycle Feedback Submission Controller
 * 
 * Validates citizen feedback submissions, applies rate limiting,
 * verifies CSRF tokens, sanitizes fields, persists to MySQL, and formats responses.
 * 
 * @package EarthCycle\Controllers
 */
class FeedbackController
{
    private FeedbackRepository $feedbackRepo;
    private array $allowedCities;

    public function __construct(array $allowedCities = [])
    {
        $this->feedbackRepo = new FeedbackRepository();
        $this->allowedCities = !empty($allowedCities) ? $allowedCities : [
            'Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Gandhinagar', 'Bhavnagar'
        ];
    }

    /**
     * Handle incoming POST submission
     *
     * @param array $input
     * @return array [ 'status' => int, 'data' => array ]
     */
    public function handleSubmission(array $input): array
    {
        if (!SecurityService::validateCsrf($input['csrf'] ?? null)) {
            return [
                'status' => 403,
                'data'   => ['status' => 'error', 'message' => 'Security token invalid or expired. Please refresh the page and try again.']
            ];
        }

        if (!SecurityService::checkRateLimit('submit_feedback', 10, 60)) {
            return [
                'status' => 429,
                'data'   => ['status' => 'error', 'message' => 'Too many requests. Please wait a minute before submitting again.']
            ];
        }

        // Validate presence
        foreach (['name', 'email', 'city', 'category', 'message', 'rating'] as $field) {
            if (!isset($input[$field]) || !is_scalar($input[$field])) {
                return [
                    'status' => 422,
                    'data'   => ['status' => 'error', 'message' => 'Please complete every report field.']
                ];
            }
        }

        $name = trim((string)$input['name']);
        $email = trim((string)$input['email']);
        $city = trim((string)$input['city']);
        $category = trim((string)$input['category']);
        $message = trim((string)$input['message']);
        $rating = filter_var($input['rating'], FILTER_VALIDATE_INT);

        // Validation rules
        if (strlen($name) < 2 || strlen($name) > 150) {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please enter your full name (2–150 characters).']];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please enter a valid email address.']];
        }

        if (strlen($message) < 8 || strlen($message) > 5000) {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please enter a feedback message of 8–5000 characters.']];
        }

        if ($rating === false || $rating < 1 || $rating > 5) {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please select 1–5 stars.']];
        }

        if (!in_array($city, $this->allowedCities, true) || $city === 'All') {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please select a valid Gujarat city.']];
        }

        $allowedCategories = [
            'Gujarat Facility Update',
            'Guide Content Review',
            'Home Compost Experience',
            'General Suggestion'
        ];
        if (!in_array($category, $allowedCategories, true)) {
            return ['status' => 422, 'data' => ['status' => 'error', 'message' => 'Please select a valid category.']];
        }

        try {
            $report = $this->feedbackRepo->create([
                'name'     => $name,
                'email'    => $email,
                'city'     => $city,
                'rating'   => $rating,
                'category' => $category,
                'message'  => $message,
            ]);

            // Render report card HTML for seamless dynamic prepend in client
            ob_start();
            include __DIR__ . '/../../includes/report-card.php';
            $cardHtml = ob_get_clean();

            return [
                'status' => 201,
                'data'   => [
                    'status'  => 'success',
                    'message' => "Thank you, {$name}! Your report has been saved and added to the community feed.",
                    'html'    => $cardHtml,
                ]
            ];
        } catch (Throwable $e) {
            error_log('EarthCycle save failed: ' . $e->getMessage());
            return [
                'status' => 503,
                'data'   => ['status' => 'error', 'message' => 'Your report could not be saved. Please try again later.']
            ];
        }
    }
}
