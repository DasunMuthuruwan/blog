<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BlockDarkWebUrlsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $host = parse_url($value, PHP_URL_HOST);

        // Block .onion domains
        if (str_ends_with($host, '.onion')) {
            $fail('The :attribute must not be a dark web or suspicious URL.');
            return;
        }

        // Optional: Block IP-based or localhost URLs
        if (filter_var($host, FILTER_VALIDATE_IP) || $host === 'localhost') {
            $fail('The :attribute must not be an IP or localhost URL.');
        }
    }
}
