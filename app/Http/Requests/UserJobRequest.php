<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserJobRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'job_name' => request()->isMethod('put') ? '' : 'required',
            'job_description' => request()->isMethod('put') ? '' : 'required',
            'user_id' => '',
            'expert_id' => request()->isMethod('put') ? '' : 'required',
            'status_id' => '',
            'attachments' => 'array',
        ];
    }
}
