<?php

namespace App\Http\Requests\Comment;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
                'min:3',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) < 5 && substr_count($value, 'http') > 1) {
                        $fail('The comment appears to be spam');
                    }
                }
            ],
        ];
    }

}
