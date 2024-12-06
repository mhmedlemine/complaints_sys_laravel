<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartCheckupRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'type' => 'required|in:regular,complaint',
            'complaint_id' => 'required_if:type,complaint|exists:complaints,id',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ];
    }
}