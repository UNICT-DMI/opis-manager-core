<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Domanda extends Model
{
    /**
     * Campi assegnabili massivamente 
     * 
     * @var array 
     */
    protected $fillable = [
        'id', 'peso_standard', 'gruppo'
    ]; 

    /**
     * Tabella referenziata dal modello
     * 
     * @var string
     */
    protected $table = 'domanda'; 
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id'; 
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; 

    /**
     * The "type" of the ID.
     *
     * @var string
     */
    protected $keyType = 'int'; 
    
    /**
     * Attraverso il json passato come parametro, vengono aggiornati tutti i 
     * record della tabella Domande. Il parametro deve essere sottoposto a 
     * validazione (vedasi Rules\MatchPesiSchema). 
     *
     * @param  mixed $validJson
     * @return void
     */
    public static function updateAllUsingJson(string $validJson): void 
    {
        $domande = json_decode($validJson);  

        foreach ($domande as $domanda) {
            DB::table('domanda')
                ->where('id', $domanda->id)
                ->update(['gruppo' => $domanda->gruppo, 'peso_standard' => $domanda->peso]); 
        }    
    }
}
