<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * 💡 このリクエストを許可するかどうか（今回は全員許可するので true にします）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 💡 バリデーションルール（入力チェックのルール）
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // 必須、文字列、255文字以内
            'price' => 'required|integer|min:0', // 必須、整数、0以上
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 必須、画像ファイルのみ、2MB以内
            'seasons' => 'required|array|min:1', // 必須、配列（チェックボックス）、最低1つ選択
            'description' => 'required|string', // 必須、文字列
        ];
    }

    /**
     * 💡 エラーメッセージの日本語化（ユーザーに見せる優しいメッセージ）
     */
    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上に設定してください。',
            'image.required' => '画像を選択してください。',
            'image.image' => '指定されたファイルが画像ではありません。',
            'seasons.required' => '季節を1つ以上選択してください。',
            'description.required' => '商品説明を入力してください。',
        ];
    }
}
