<?php

namespace App\Http\Requests;

use App\Http\Middleware\MyAuth;
use App\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChangeCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return MyAuth::hasPermission(PermissionEnum::SPECIAL_PERM__ALLOW_FOR_ADMIN, auth()->user()->role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "company" => "required|numeric"
        ];
    }
}
