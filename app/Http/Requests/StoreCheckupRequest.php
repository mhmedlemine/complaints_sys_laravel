<?php
// app/Http/Requests/StoreCheckupRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckupRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'entreprise_id' => 'required|exists:entreprises,id',
            'notes' => 'nullable|string',
            'infractions' => 'nullable|array',
            'infractions.*.infraction_id' => 'nullable|exists:infractions,id',
            'infractions.*.custom_infraction_text' => 'nullable|string',
            'infractions.*.notes' => 'nullable|string',
            'infractions.*.evidence_files' => 'nullable|array',
            'infractions.*.evidence_files.*.file' => 'required|file|mimes:jpeg,png,pdf,doc,docx,mp3,mp4|max:10240',
            'infractions.*.evidence_files.*.type' => 'required|in:image,document,audio,video',
            'infractions.*.evidence_files.*.description' => 'nullable|string',
        ];
    }
}