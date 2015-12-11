<?php

namespace App\Http\Requests;

class IssueRequest extends Request
{
    /**
     * The issue validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|min:5',
            'occurred_at'   => 'min:18|max:19',
            'description'   => 'required|min:5',
        ];
    }

    /**
     * Allows all users to create issues.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
