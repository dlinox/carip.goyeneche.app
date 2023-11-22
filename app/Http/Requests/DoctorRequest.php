<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
        // $userId = $this->id ?  $this->id : null;
        //obtener valor de la consulta post del body
        $personId = $this->post('personId') ? $this->post('personId') : null;

        return [
            'name' => 'required',
            'fatherLastName' => 'required',
            'motherLastName' => 'required',
            'documentNumber' => 'required|unique:persons,document_number,' . $personId,
            'specialty' => 'required',
            'description' => 'nullable',
            'photo' => $personId ?  'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' :  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
