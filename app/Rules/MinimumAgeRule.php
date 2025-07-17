<?php

namespace App\Rules;

use Carbon\CarbonInterval;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class MinimumAgeRule implements ValidationRule
{
    public function __construct(public object $user){}
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!empty($this->user->password_changed_at) && Carbon::parse($this->user->password_changed_at)->diffInSeconds(Carbon::now()) <= config('auth.seconds_for_day')) {
            $minTime = CarbonInterval::seconds(config('auth.seconds_for_day'))->cascade()->forHumans();

            $fail("It has not been {$minTime} since the password was changed");
        }
    }
}
