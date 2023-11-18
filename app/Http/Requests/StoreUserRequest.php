<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            //
            'personnel_id'=>['required','string','min:5','max:10','unique:users'],
            'name'=>['required','string','min:3','max:255'],
            'contact'=>['required','string','min:10','max:15'],
            'location'=>['required','string','max:255'],
            'password'=>['required','string','min:6','max:255'],
            'position'=>['required','string','max:255'],
            'role'=>['required','boolean']
        ];
    }
}
