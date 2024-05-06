<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoanValidator
{
    /**
     * @throws ValidationException
     */
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'amount' => 'nullable|numeric',
            'duration' => 'nullable|integer',
            'interest_rate' => 'nullable|numeric',
        ]);

        return $validator->validate();
    }
}
