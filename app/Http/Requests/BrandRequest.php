<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // lấy id nếu là update, null nếu là store

        return [
            'brandname' => [
                'bail',
                'required',
                'min:5',
                'max:20',
                'unique:brands,brandname' . ($id ? ',' . $id : ''),
                'regex:/^[\p{L}\d\s]+$/u' // chỉ chữ cái có dấu, số, khoảng trắng
            ],
            'description' => [
                'bail',
                'nullable',
                'min:5',
                'regex:/^[^@#$]*$/', // không chứa @, #, $
            ],
            'status' => ['bail', 'required', 'in:0,1']
        ];
    }


    public function attributes(): array
    {
        return [
            'brandname' => 'Tên thương hiệu',
            'description' => 'Mô tả',
            'status' => 'Trạng thái'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải có ít nhất :min ký tự',
            'max' => ':attribute không vượt quá :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'regex' => ':attribute không được chứa ký tự @, #, $',
            'in' => ':attribute không hợp lệ',
        ];
    }
}
