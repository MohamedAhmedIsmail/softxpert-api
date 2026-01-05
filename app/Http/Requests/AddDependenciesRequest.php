<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDependenciesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isManager() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dependency_task_ids' => ['required','array','min:0'],
            'dependency_task_ids.*' => ['integer','distinct','exists:tasks,id'],
        ];
    }
}
