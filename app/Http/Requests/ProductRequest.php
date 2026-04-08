<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // null nếu là create

        return [
            'proname' => [
                'bail',
                'required',
                'min:5',
                'max:20',
                'unique:products,proname' . ($id ? ',' . $id : ''),
                'regex:/^[\p{L}\d\s]+$/u', // chỉ cho chữ có dấu, số và khoảng trắng
            ],
            'price' => [
                'bail',
                'required',
                'numeric',
                'min:100000',
                'max:100000000'
            ],
            'cateid' => [
                'bail',
                'required',
                'exists:categories,cateid',
                'regex:/^[\p{L}\d\s]+$/u'
            ],
            'brandid' => [
                'bail',
                'nullable',
                'exists:brands,id',
                'regex:/^[\p{L}\d\s]*$/u'
            ],
            'description' => [
                'bail',
                'nullable',
                'min:5',
                'regex:/^[^@#$]*$/', // không chứa @ # $
            ],
            'status' => [
                'bail',
                'required',
                'in:0,1'
            ],
            // không bắt buoc phải upload ảnh
            // nếu có file ảnh phải có định dạng jpg, jpeg, png. Kích thước toi đa 200KB
            // bail: nếu có lỗi thì dừng lại khong kiểm tra cac rule sau
            'fileName' => 'bail|nullable|image|mimes:jpg,jpeg,png|max:200'
        ];
    }

    public function attributes(): array
    {
        return [
            'proname' => 'Tên sản phẩm',
            'price' => 'Giá',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả',
            'status' => 'Trạng thái'
        ];
    }

    public function messages(): array
    {
        return [
            // Chung
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại',
            'numeric' => ':attribute phải là số',
            'regex' => ':attribute không hợp lệ (chỉ cho chữ, số, khoảng trắng; không chứa @, #, $)',
            'in' => ':attribute không hợp lệ',
            'exists' => ':attribute không tồn tại trong hệ thống',

            // Riêng từng trường với min, max
            'proname.min' => 'Tên sản phẩm phải có ít nhất :min ký tự',
            'proname.max' => 'Tên sản phẩm không vượt quá :max ký tự',

            'description.min' => 'Mô tả phải có ít nhất :min ký tự',

            'price.min' => 'Giá tối thiểu là :min đồng',
            'price.max' => 'Giá tối đa là :max đồng',

            'fileName.max' => 'Ảnh không được vượt quá 200KB',
            'fileName.image' => 'Ảnh phải là định dạng hình ảnh',
            'fileName.mimes' => 'Ảnh phải có định dạng: jpg, jpeg hoặc png',
        ];
    }
}
