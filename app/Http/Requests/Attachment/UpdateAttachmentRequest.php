<?php

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Attachment;

class UpdateAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('attachment'));
    }

    public function rules(): array
    {
        return [
            'file_name' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'file_name.string' => 'File name must be a string.',
            'file_name.max' => 'File name should not exceed 255 characters.',
        ];
    }
}
