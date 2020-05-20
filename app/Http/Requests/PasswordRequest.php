<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
            return [
                'current-password' => 'required',
                'new-password' => 'required|string|min:8|max:50|confirmed',
            ];
    }

    public function messages() {
        return [
            'current-password.required' => "現在のパスワードは必須項目です。",
            'new-password.required' => "新しいパスワードは必須項目です。",
            "new-password.min" => "新しいパスワードは8文字以上で入力してください。",
            "new-password.max" => "新しいパスワードは50文字以内で入力してください。",
            "new-password.confirmed" => "確認用のパスワードと一致しません"
        ];
      }
}
