<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array{
        $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'text' => ''
        ];
        
      switch($this->getMethod()){
        case 'POST': return $rules;
        case 'PUT': return ['id' => 'required|integer|exists:forms,id'] + $rules;
        case 'DELETE': return ['id' => 'required|integer|exists:forms,id'];
    }
    }
}
