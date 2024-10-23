<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255', // Tên là bắt buộc, kiểu chuỗi, tối đa 255 ký tự
            'phone' => [
                'required',
                'string',
                'regex:/^(0[1-9][0-9]{8}|1[0-9]{9}|[1-9][0-9]{0,7})$/', // Quy tắc regex cho số điện thoại Việt Nam
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là một chuỗi.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại hợp lệ.',
        ];
    }
}
