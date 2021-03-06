<?php

namespace App\Http\Requests;

use App\Http\Requests\InsegnamentoAttributes;

class InsegnamentoRequest extends InsegnamentoAttributes
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $imposeAnnoAccademico = ['anno_accademico' => 'required|string']; 

        return array_merge(parent::rules(), $imposeAnnoAccademico); 
    }
}
