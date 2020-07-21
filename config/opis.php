<?php

return [

            /**
             *  
             *  
             *   
             *  
             * 

             * 

             */

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
    ]

]; 