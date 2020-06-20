<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SchedeOpis extends Model
{
    /**
     * Campi assegnati massivamente 
     * 
     * @var Array 
     */
    protected $fillable = [
        'anno_accademico', 'totale_schede', 'totale_schede_nf', 'femmine',
        'femmine_nf', 'fc', 'inatt', 'inatt_nf',  'eta', 'anno_iscr', 
        'num_studenti', 'ragg_uni', 'studio_gg', 'studio_tot',
        'domande', 'domande_nf', 'motivo_nf', 'sugg', 'sugg_nf', 'id_insegnamento' 
    ]; 

    /**
     * Tabella referenziata dal modello
     * 
     * @var string
     */
    protected $table = 'schede_opis'; 

    /**
     * Flag referente i timestamps nelle tabelle
     * 
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Ritorna l'insegnamento a cui le schede opis sono associate
     *
     * @return void
     */
    public function insegnamento()
    {
        return $this->belongsTo('App\Models\Insegnamento', 'id_insegnamento');
    }
}
