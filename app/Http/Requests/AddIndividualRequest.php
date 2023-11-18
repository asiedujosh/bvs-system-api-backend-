<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddIndividualRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'clientId'=>['required','string','min:8','max:15','unique:clients'],
            'clientName'=>['required','string','min:3','max:255'],
            'clientTel'=>['required','string','min:10','max:15'],
            'clientLocation'=>['required','string','max:255'],
            'productId'=>['required','string','min:8','max:15','unique:products'],
            'carType'=>['required','string','max:255'],
            'carColor'=>['required','string','max:255'],
            'plateNo'=>['required','string','max:255'],
            'chasisNo'=>['required','string','max:255'],
            'requestDate'=>['required'],
        ];
    }
}
