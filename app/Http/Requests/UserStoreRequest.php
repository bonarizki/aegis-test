<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'required|string|min:3|max:50',
            "email" => 'required|string|email|unique:users,email',
            "password" => 'required|string|min:8'
        ];
    }

    /**
     * Method failedValidation
     * 
     * for custome response when validation failed
     *
     * @param Validator $validator [explicite description]
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'false' => 'failed',
            'errors' => $validator->errors()->all()
        ], 400));
    }
}
