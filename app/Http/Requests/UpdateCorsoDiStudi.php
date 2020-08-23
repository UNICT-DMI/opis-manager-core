<?php

namespace App\Http\Requests;

use App\Http\Requests\UpdatePesi;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCorsoDiStudi extends UpdatePesi
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
        $scostamenti = [
            'scostamento_numerosita' => 'numeric|min:0', 
            'scostamento_media' => 'numeric|min:0'
        ]; 

        return array_merge(parent::rules(), $scostamenti); 
    }
}
