<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(Request $request): array
    {
        $rules = [
            'payer_name' => ['min:3', 'max:255', 'string'],
            'payer_document' => ['string', 'max:255'],
            'payer_phone' => ['string', 'max:15'],
            'payer_email' => ['email'],
            'payer_birthday' => ['date'],
            'payer_address_cep' => ['size:8'],
            'payer_address_street' => ['min:3', 'max:255'],
            'payer_address_district' => ['min:3', 'max:255'],
            'payer_address_number' => ['integer', 'nullable'],
            'payer_address_complement' => ['min:3', 'string', 'nullable'],
            'payer_address_city' => ['min:3', 'string', 'max:255'],
            'payer_address_state' => ['size:2', 'string'],
        ];

        if ($request->method === self::METHOD_POST) {
            $rules = $this->setRequiredRule($rules, [
                'payer_name',
                'payer_document',
                'payer_phone',
                'payer_email',
                'payer_birthday',
                'payer_address_cep',
                'payer_address_street',
                'payer_address_district',
                'payer_address_city',
                'payer_address_state',
            ]);
        }

        return $rules;
    }

    public function setRequiredRule(array $rules, array $required_rules): array
    {
        foreach ($required_rules as $rule) {
            $rules[$rule][] = 'required';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, new JsonResponse([
            'success' => false,
            'message' => 'Validation error.',
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
