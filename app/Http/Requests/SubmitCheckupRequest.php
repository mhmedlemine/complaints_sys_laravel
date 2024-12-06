<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCheckupRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'infractions' => 'nullable|array',
            'infractions.*.id' => 'nullable|exists:infractions,id',
            'infractions.*.custom_infraction_text' => 'nullable|string',
            'infractions.*.notes' => 'nullable|string',
            'infractions.*.evidence_files' => 'nullable|array',
            'infractions.*.evidence_files.*.file' => [
                'required',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'infractions.*.evidence_files.*.file' => 'required|file|mimes:jpeg,png,pdf,doc,docx,mp3,mp4|max:10240',
            'infractions.*.evidence_files.*.type' => 'required|in:image,document,audio,video',
            'infractions.*.evidence_files.*.description' => 'nullable|string',
            'custom_infractions' => 'array|nullable',
            'custom_infractions.*.text' => 'required|string',
            'custom_infractions.*.notes' => 'nullable|string',
            'custom_infractions.*.evidence_files' => 'nullable|array',
            'custom_infractions.*.evidence_files.*.file' => [
                'required',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'custom_infractions.*.evidence_files.*.type' => 'required|in:image,document,audio,video',
            'custom_infractions.*.evidence_files.*.description' => 'nullable|string',
            'duedate' => 'required|date',
            'action_taken' => 'required|in:none,closed,summon_issued',
            'notes' => 'nullable|string',
        ];
    }
}