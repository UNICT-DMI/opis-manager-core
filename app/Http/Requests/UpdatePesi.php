<?php

namespace App\Http\Requests;

use App\Rules\PesiBilanciati;
use App\Rules\MatchPesiSchema;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePesi extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'pesi_domande' => [
                'bail', 'required', 'json', 
                new MatchPesiSchema, 
                new PesiBilanciati
            ]
        ];
    }
}
