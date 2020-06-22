<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Insegnamento extends Model
{
    /**
     * Campi assegnati massivamente 
     * 
     * @var Array 
     */
    protected $fillable = [
        'codice_gomp', 'nome', 'anno_accademico', 
        'ssd', 'anno', 'semestre', 'cfu', 'docente',
        'canale', 'id_modulo', 'nome_modulo', 'tipo', 
        'assegn', 'id_cds'
    ]; 

    /**
     * Tabella referenziata dal modello
     * 
     * @var string
     */
    protected $table = 'insegnamento'; 

    /**
     * Flag referente i timestamps nelle tabelle
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Ritorna il cds a cui l'insegnamento è associato
     *
     * @return Relation
     */
    public function corsoDiStudi(): Relation 
    {
        return $this->belongsTo('App\Models\CorsoDiStudi', 'id_cds');
    }
    
    /**
     * Ritorna tutte le schede opis associate al cds
     *
     * @return Relation
     */
    public function schedeOpis(): Relation
    {
        return $this->hasMany('App\Models\SchedeOpis', 'id_insegnamento');
    }
}
