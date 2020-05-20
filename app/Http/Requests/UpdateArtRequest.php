<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtRequest extends FormRequest
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
        if ($this->change) {
            return [
                'photo' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',//画像のバリデーション
                'categories' => 'required|max:5',//カテゴリのバリデーション
                'title' => 'required|max:50',
                'comment' => 'required|max:255',
            ];
        }

        return [
            //
            'categories' => 'required|max:5',//カテゴリのバリデーション
            'title' => 'required|max:50',
            'comment' => 'required|max:255',
        ];
    }

    public function messages() {
        return [
            "photo.file" => '添付はファイルを指定してください。',
            "photo.image" => '画像ファイルを指定してください。',
            "photo.mimes" => '画像にはjpeg,png,jpg,gifのうちいずれかの形式のファイルを指定してください。',
            "photo.max" => '画像には2048KB以下のファイルを指定してください。',
            "photo.required" => "「画像を変更する」にチェックがある場合は画像は必須です。",
            "categories.required" => "カテゴリは1個以上選択してください。",
            "categories.max" => "カテゴリは5個以下にしてください。",
            "title.required" => "タイトルは必須項目です。",
            "title.max" => "タイトルは50文字以内で入力してください。",
            "comment.required" => "内容は必須項目です。",
            "comment.max" => "内容は255文字以内で入力してください。",
        ];
    }
}
