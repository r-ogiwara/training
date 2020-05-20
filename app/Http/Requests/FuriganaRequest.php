<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuriganaRequest extends FormRequest
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
            'name' => 'required|max:10',//未入力はエラー
            'furigana' => 'nullable|max:10|regex:/^[あ-ん゛゜ぁ-ぉゃ-ょー]+$/u',//ひらがな入力エラー
        ];
    }

    public function messages() {
        return [
            "name.required" => "カテゴリ名は必須項目です。",
            "name.max" => "カテゴリ名は10文字以内で入力してください。",
            "furigana.regex" => "ひらがなで入力してください。",
            "furigana.max" => "ふりがなは10文字以内で入力してください。",
        ];
      }
}
