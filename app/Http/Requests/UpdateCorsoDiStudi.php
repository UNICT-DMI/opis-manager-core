<?php

namespace App\Http\Requests;

use App\Rules\PesiBilanciati;
use App\Rules\MatchPesiSchema;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCorsoDiStudi extends FormRequest
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
            'pesi_domande' => ['bail', 'json', new MatchPesiSchema, new PesiBilanciati], 
            'scostamento_numerosita' => 'numeric|min:0', 
            'scostamento_media' => 'numeric|min:0'
        ]; 
    }
}
