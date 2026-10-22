<?php
declare(strict_types=1);

namespace EarthCycle\Models;

/**
 * EarthCycle Citizen Feedback & Field Report Model
 * 
 * Represents feedback submitted by citizens, home composters, or municipal visitors.
 * 
 * @package EarthCycle\Models
 */
class Feedback
{
    private int $id;
    private string $name;
    private string $email;
    private string $city;
    private int $rating;
    private string $category;
    private string $message;
    private string $date;
    private string $status;

    public function __construct(array $attributes = [])
    {
        $this->id = (int)($attributes['id'] ?? 0);
        $this->name = (string)($attributes['name'] ?? '');
        $this->email = (string)($attributes['email'] ?? '');
        $this->city = (string)($attributes['city'] ?? 'Ahmedabad');
        $this->rating = max(1, min(5, (int)($attributes['rating'] ?? 5)));
        $this->category = (string)($attributes['category'] ?? 'General Suggestion');
        $this->message = (string)($attributes['message'] ?? '');
        $this->date = (string)($attributes['date'] ?? 'Just now');
        $this->status = (string)($attributes['status'] ?? 'Approved');
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getCity(): string { return $this->city; }
    public function getRating(): int { return $this->rating; }
    public function getCategory(): string { return $this->category; }
    public function getMessage(): string { return $this->message; }
    public function getDate(): string { return $this->date; }
    public function getStatus(): string { return $this->status; }

    /**
     * Obfuscate email for public display privacy
     *
     * @return string
     */
    public function getMaskedEmail(): string
    {
        if (empty($this->email) || strpos($this->email, '@') === false) {
            return '';
        }
        [$local, $domain] = explode('@', $this->email, 2);
        $maskedLocal = strlen($local) <= 2 ? $local . '***' : substr($local, 0, 2) . '***' . substr($local, -1);
        return $maskedLocal . '@' . $domain;
    }

    /**
     * Convert to array for view rendering and JSON serialization
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->getMaskedEmail(),
            'city'     => $this->city,
            'rating'   => $this->rating,
            'category' => $this->category,
            'message'  => $this->message,
            'date'     => $this->date,
            'status'   => $this->status,
        ];
    }
}
