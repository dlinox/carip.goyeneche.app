<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->id ?  $this->id : null;

        return [
            'name' => 'required',
            'fatherLastName' => 'required',
            'motherLastName' => 'required',
            'documentNumber' => 'required|unique:users,document_number,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'phoneNumber' => 'required',
            'password' => $userId ? '' : 'required',
            'role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'fatherLastName.required' => 'El apellido paterno es requerido',
            'motherLastName.required' => 'El apellido materno es requerido',
            'documentNumber.required' => 'El número de documento es requerido',
            'documentNumber.unique' => 'El número de documento ya existe',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'El correo electrónico ya existe',
            'phoneNumber.required' => 'El teléfono es requerido',
            'password.required' => 'La contraseña es requerida',
            'role.required' => 'El rol es requerido',
        ];
    }
}
