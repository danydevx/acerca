<?php

namespace Modules\Analytics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnalyticsCollectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->input('type');

        $rules = [
            'type' => ['required', Rule::in(['pageview', 'event'])],
            'path' => 'string|max:500',
            'url' => 'string|max:2000',
            'referrer' => 'string|max:2000|nullable',
            'screen_width' => 'integer|min:0|max:10000|nullable',
            'screen_height' => 'integer|min:0|max:10000|nullable',
            'utm_source' => 'string|max:100|nullable',
            'utm_medium' => 'string|max:100|nullable',
            'utm_campaign' => 'string|max:100|nullable',
            'utm_term' => 'string|max:100|nullable',
            'utm_content' => 'string|max:100|nullable',
            'page_title' => 'string|max:500|nullable',
            'query_string' => 'string|max:1000|nullable',
        ];

        if ($type === 'event') {
            $rules['event_name'] = 'required|string|max:100';
            $rules['metadata'] = 'array|nullable';
            $rules['metadata.*'] = 'string|max:500';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Track type is required',
            'type.in' => 'Track type must be pageview or event',
            'event_name.required' => 'Event name is required for event tracking',
        ];
    }
}
