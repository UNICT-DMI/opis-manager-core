<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Dipartimento extends Model
{
    /**
     * Campi assegnati massivamente 
     * 
     * @var Array 
     */
    protected $fillable = ['unict_id', 'nome', 'anno_accademico']; 

    /**
     * Tabella referenziata dal modello
     * 
     * @var string
     */
    protected $table = 'dipartimento'; 

    /**
     * Flag referente i timestamps nelle tabelle
     * 
     * @var bool
     */
    public $timestamps = false; 
}
