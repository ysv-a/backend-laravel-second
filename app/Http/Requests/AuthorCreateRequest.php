<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AuthorCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['string', 'max:255'],
            'biography' => ['string', 'max:255'],
            'email' => ['required', 'email:rfc,dns'],
        ];
    }
}
