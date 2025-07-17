<?php

namespace App;

use App\Rules\MinimumAgeRule;
use Illuminate\Validation\Rules\Password;

trait PasswordValidationRuleTrait
{
    /**
     * return password validation Rules.
     *
     * @param object $user user
     * @return array
     */
    protected function passwordRules(?object $user): array
    {
        return [
            Password::min(8)->mixedCase()->numbers()->symbols(),
            new MinimumAgeRule($user)
        ];
    }
}
