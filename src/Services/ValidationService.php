<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Input Validation Service
 * 
 * Provides robust validation rules for forms, API payloads, and query parameters.
 * 
 * @package EarthCycle\Services
 */
class ValidationService
{
    private array $errors = [];
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Factory method
     *
     * @param array $data
     * @return self
     */
    public static function make(array $data): self
    {
        return new self($data);
    }

    /**
     * Validate required field
     *
     * @param string $field
     * @param string|null $message
     * @return self
     */
    public function required(string $field, ?string $message = null): self
    {
        $val = $this->data[$field] ?? null;
        if ($val === null || (is_string($val) && trim($val) === '')) {
            $this->addError($field, $message ?? "Field '{$field}' is required.");
        }
        return $this;
    }

    /**
     * Validate string length
     *
     * @param string $field
     * @param int $min
     * @param int $max
     * @param string|null $message
     * @return self
     */
    public function stringLength(string $field, int $min, int $max, ?string $message = null): self
    {
        $val = trim((string)($this->data[$field] ?? ''));
        $len = strlen($val);
        if ($len < $min || $len > $max) {
            $this->addError($field, $message ?? "Field '{$field}' must be between {$min} and {$max} characters.");
        }
        return $this;
    }

    /**
     * Validate email format
     *
     * @param string $field
     * @param string|null $message
     * @return self
     */
    public function email(string $field, ?string $message = null): self
    {
        $val = trim((string)($this->data[$field] ?? ''));
        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $message ?? "Please enter a valid email address.");
        }
        return $this;
    }

    /**
     * Validate integer range
     *
     * @param string $field
     * @param int $min
     * @param int $max
     * @param string|null $message
     * @return self
     */
    public function integerRange(string $field, int $min, int $max, ?string $message = null): self
    {
        $val = filter_var($this->data[$field] ?? null, FILTER_VALIDATE_INT);
        if ($val === false || $val < $min || $val > $max) {
            $this->addError($field, $message ?? "Field '{$field}' must be an integer between {$min} and {$max}.");
        }
        return $this;
    }

    /**
     * Validate value is in allowed whitelist
     *
     * @param string $field
     * @param array $allowed
     * @param string|null $message
     * @return self
     */
    public function inList(string $field, array $allowed, ?string $message = null): self
    {
        $val = $this->data[$field] ?? null;
        if (!in_array($val, $allowed, true)) {
            $this->addError($field, $message ?? "Selected value for '{$field}' is invalid.");
        }
        return $this;
    }

    /**
     * Check if validation passed
     *
     * @return bool
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     *
     * @return bool
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get all validation errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the first error message
     *
     * @return string|null
     */
    public function getFirstError(): ?string
    {
        foreach ($this->errors as $msgs) {
            if (!empty($msgs)) {
                return $msgs[0];
            }
        }
        return null;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
