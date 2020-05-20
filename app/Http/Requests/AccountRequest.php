<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:20'],
                //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                //'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
                'introduction' => ['max:255'],
                'lastname' => ['required', 'string', 'max:20'],
                'firstname' => ['required', 'string', 'max:20'],
                'zip21' => ['required', 'string', 'max:3'],
                'zip22' => ['required', 'string', 'max:4'],
                'pref21' => ['required', 'string', 'max:50'],
                'addr21' => ['required', 'string', 'max:50'],
                'strt21' => ['required', 'string', 'max:255'],
            ];
    }

    public function messages() {
        return [
            'name' => "アカウント名",
            'introduction' => '自己紹介'
        ];
      }
}
