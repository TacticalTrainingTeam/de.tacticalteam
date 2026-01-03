<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sanitize input for common HTTP methods that accept data
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $input = $request->all();
            $sanitized = $this->sanitizeArray($input);
            $request->replace($sanitized);
        }

        return $next($request);
    }

    /**
     * Recursively sanitize array values
     */
    private function sanitizeArray(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeArray($value);
            } elseif (is_string($value)) {
                $sanitized[$key] = $this->sanitizeString($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize a string value against XSS attacks
     */
    private function sanitizeString(string $value): string
    {
        // Remove null bytes
        $value = str_replace(chr(0), '', $value);

        // Remove control characters
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        // HTML encode potentially dangerous characters
        // This prevents script execution while preserving content
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
    }
}
