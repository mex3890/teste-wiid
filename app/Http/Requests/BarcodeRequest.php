<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BarcodeRequest extends FormRequest
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
        $required_condition = $request->method === self::METHOD_POST;

        return [
            'payer_id' => ['integer', Rule::requiredIf(function () use ($required_condition) {
                return $required_condition;
            }), Rule::in(Auth::user()->payers()->get()->pluck('id'))],
            'valid_until' => ['date', Rule::requiredIf(function () use ($required_condition) {
                return $required_condition;
            })],
            'barcode_value' => ['min:0', 'decimal:0,2', Rule::requiredIf(function () use ($required_condition) {
                return $required_condition;
            })],
            'instruction_1' => ['string'],
            'instruction_2' => ['string'],
            'instruction_3' => ['string'],
            'description' => ['string', Rule::requiredIf(function () use ($required_condition) {
                return $required_condition;
            })],
            'ticket_type' => ['nullable', Rule::in([1, 2])],
            'ticket_value' => ['min:0', 'required_with:ticket_type', 'decimal:0,2'],
            'interest_rate_type' => ['nullable', Rule::in([1, 2])],
            'interest_rate_value' => ['min:0', 'required_with:interest_rate_type', 'decimal:0,2'],
            'discount_type' => ['nullable', Rule::in([1, 2])],
            'discount_value' => ['min:0', 'required_with:discount_type', 'decimal:0,2'],
            'discount_limit_date' => ['required_with:discount_type', 'date'],
            'reference' => ['string'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated_fields = parent::validated();

        if ($this->request->get('ticket_type', false) === null) {
            $validated_fields = array_merge($validated_fields, ['ticket_value' => null]);
        }

        if ($this->request->get('discount_type', false) === null) {
            $validated_fields = array_merge($validated_fields, [
                'discount_value' => null,
                'discount_limit_date' => null
            ]);
        }

        if ($this->request->get('interest_rate_type', false) === null) {
            $validated_fields = array_merge($validated_fields, ['interest_rate_value' => null]);
        }

        return $validated_fields;
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
