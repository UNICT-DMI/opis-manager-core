<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valore di scostamento 
    |--------------------------------------------------------------------------
    |
    | Lo scostamento dalla media è un parametro analizzante del corso di studi.
    | È definito rispetto alla numerosità delle schede compilate e alla media
    | delle votazioni ottenute. Esempio:
    | media schede compilate:           100
    | schede compilate nel cds:         50
    | scostamento numerosità:           40
    | 100 - 50 = 50 > 40 (scostamento) => situazione allarmante. 
    |
    */

    'scostamento' => [
        'numerosita_schede'     => 50, 
        'media_di_valutazione'  => 20
    ], 

    /*
    |--------------------------------------------------------------------------
    | Pesi iniziali
    |--------------------------------------------------------------------------
    |
    | I seguenti pesi sono attributi alle domande residenti nelle schede opis. 
    | I valori riportati sono esclusivamente iniziali e sono stati prelevati 
    | dai valori riportati nel sito ufficiale. I pesi potranno essere in seguito
    | modificati attraverso le API. 
    | 
    */
    'domande' => [
        
        ['id' => 1,  'peso_standard' => 0.7, 'gruppo' => 'V1'], 
        ['id' => 2,  'peso_standard' => 0.3, 'gruppo' => 'V1'],

        ['id' => 4,  'peso_standard' => 0.1, 'gruppo' => 'V2'], 
        ['id' => 5,  'peso_standard' => 0.3, 'gruppo' => 'V2'], 
        ['id' => 9,  'peso_standard' => 0.3, 'gruppo' => 'V2'], 
        ['id' => 10, 'peso_standard' => 0.3, 'gruppo' => 'V2'], 

        ['id' => 3,  'peso_standard' => 0.1, 'gruppo' => 'V3'], 
        ['id' => 6,  'peso_standard' => 0.5, 'gruppo' => 'V3'], 
        ['id' => 7,  'peso_standard' => 0.4, 'gruppo' => 'V3'], 

        ['id' => 8,  'peso_standard' => 0.0, 'gruppo' => null], 
        ['id' => 11, 'peso_standard' => 0.0, 'gruppo' => null], 
        ['id' => 12, 'peso_standard' => 0.0, 'gruppo' => null], 
        
    ]  
    
]; 