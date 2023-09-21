<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class HalfWidth implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        //
        if (strlen($value) > mb_strlen($value, 'utf8')) {
            return $fail('validation.custom.' . $attribute . '.halfwidth')->translate();
        }
    }
}
