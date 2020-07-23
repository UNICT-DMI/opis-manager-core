<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PesiBilanciati implements Rule
{
    private $gruppiAccumulator; 

    /**
     * Preso in input un array di array, dove l'array interno 
     * è formato da (id, peso, gruppo), ne ricava tutti i gruppi
     * non duplicati. 
     * 
     * @param array $array 
     * @return array (di gruppi unicamente presenti)
     */
    private function extractGruppi(array $array): array
    {
        return array_unique(array_map(function($element) {
            return $element['gruppo']; 
        }, $array)); 
    }

    /**
     * Preso un array di gruppi in input, prepara l'accumulatore settando 
     * l'attributo come un array associativo di chiave il gruppo e di valore 
     * iniziale 0. 
     * 
     * @param array (di gruppi unicamente presenti)
     * @return void 
     */
    private function setupGruppiAccumulator(array $array): void
    {
        $this->gruppiAccumulator = array_fill_keys(array_unique($array), 0); 
    }
    
    /**
     * calcola le somme dei pesi per ogni gruppo, inserendole nell'accumulatore
     *
     * @param  mixed $array
     * @return void
     */
    private function calculateSums(array $array): void 
    {
        foreach ($array as $element) 
            $this->gruppiAccumulator[$element['gruppo']] += $element['peso']; 
    }
    
    /**
     * filtra le somme regolari (< 1) e ritorna un array di somme irregolari. 
     *
     * @return array (di gruppi con somme maggiori di uno) 
     */
    private function filterRegularSums(): array
    {
        return array_filter($this->gruppiAccumulator, function ($element) {
            return $element > 1;  
        }); 
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool 
    {
        $valueDecoded = \json_decode($value, true); 
        $this->setupGruppiAccumulator($this->extractGruppi($valueDecoded)); 
        $this->calculateSums($valueDecoded); 

        return sizeof($this->filterRegularSums()) == 0; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La somma dei pesi di un gruppo non puo\' superare il valore 1.';
    }
}
