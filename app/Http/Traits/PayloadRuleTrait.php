<?php

namespace App\Http\Traits;

trait PayloadRuleTrait
{
    public function payloadRules(): array
    {
        return [
            'keyword'   => ['nullable'],
            'status'    => ['nullable'],
            'priority'  => ['nullable'],
            'take'      => ['nullable'],
            'skip'      => ['nullable'],
        ];
    }
}
