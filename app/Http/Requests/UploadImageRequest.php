<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadImageRequest
 * @package App\Http\Requests
 */
class UploadImageRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
