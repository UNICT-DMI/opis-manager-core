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
        'canale', 'modulo', 'tipo', 'assegn', 'id_cds'
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
}
