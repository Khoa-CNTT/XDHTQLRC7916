<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageUrlOrFilename implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Nếu là URL: kiểm tra xem có phải ảnh thật không
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($value, 1);
            if (!$headers || !isset($headers["Content-Type"])) {
                return false;
            }

            $contentType = is_array($headers["Content-Type"])
                ? end($headers["Content-Type"])
                : $headers["Content-Type"];

            return str_starts_with($contentType, 'image/');
        }

        // Nếu là tên file: kiểm tra đuôi
        return is_string($value) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $value);
    }

    public function message(): string
    {
        return 'Hình ảnh phải là một URL hình ảnh hợp lệ .';
    }
}
