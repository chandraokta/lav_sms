<?php

namespace App\Http\Requests\MyClass;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ClassUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $classId = $this->route('class'); // Mendapatkan ID kelas dari route parameter
        
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('my_classes')->where(function ($query) use ($request, $classId) {
                    return $query->where('class_type_id', $request->class_type_id)
                                ->where('id', '!=', $classId);
                })
            ],
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => 'Nama kelas ini sudah ada untuk tipe kelas yang sama.',
        ];
    }
}
