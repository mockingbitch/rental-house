<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Kana implements InvokableRule
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
        $pattern = '/[^\x{30A0}-\x{30FF}\x{31F0}-\x{31FF}\x{32D0}-\x{32FE}\x{3300}-\x{3357}]/u';
        preg_match_all($pattern, $value, $matches);
        
        if (! empty($matches[0])):
            $fail('validation.custom.' . $attribute . '.kana')->translate();
        endif;
    }
}

