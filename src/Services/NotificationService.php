<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Flash Notifications & Message Banner Service
 * 
 * Manages one-time session flash alerts (success, error, warning, info) for user actions.
 * 
 * @package EarthCycle\Services
 */
class NotificationService
{
    /**
     * Set a flash message in session
     *
     * @param string $type 'success', 'error', 'warning', 'info'
     * @param string $message
     * @return void
     */
    public static function flash(string $type, string $message): void
    {
        SecurityService::initSession();
        $_SESSION['flash_messages'][] = [
            'type'      => $type,
            'message'   => $message,
            'timestamp' => time(),
        ];
    }

    /**
     * Retrieve all pending flash messages and clear them from session
     *
     * @return array
     */
    public static function getFlashes(): array
    {
        SecurityService::initSession();
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }

    /**
     * Render flash messages as Tailwind CSS toast alerts
     *
     * @return string
     */
    public static function renderFlashes(): string
    {
        $messages = self::getFlashes();
        if (empty($messages)) {
            return '';
        }

        $html = '<div class="space-y-3 mb-6">';
        foreach ($messages as $msg) {
            $type = $msg['type'];
            $text = SecurityService::escape($msg['message']);

            $styleClass = match ($type) {
                'success' => 'bg-emerald-500/20 border-emerald-400/40 text-emerald-200',
                'error'   => 'bg-rose-500/20 border-rose-400/40 text-rose-200',
                'warning' => 'bg-amber-500/20 border-amber-400/40 text-amber-200',
                default   => 'bg-teal-500/20 border-teal-400/40 text-teal-200',
            };

            $html .= "<div class=\"p-4 rounded-2xl border text-xs font-medium flex items-center justify-between {$styleClass}\">";
            $html .= "<span>{$text}</span>";
            $html .= '<button type="button" onclick="this.parentElement.remove()" class="text-white/60 hover:text-white ml-4 text-sm font-bold">&times;</button>';
            $html .= '</div>';
        }
        $html .= '</div>';

        return $html;
    }
}
