<?php

namespace App\Models;

use App\Models\Dipartimento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class CorsoDiStudi extends Model
{
    /**
     * Campi assegnati massivamente 
     * 
     * @var Array 
     */
    protected $fillable = ['unict_id', 'nome', 'classe', 'anno_accademico', 'id_dipartimento']; 

    /**
     * Tabella referenziata dal modello
     * 
     * @var string
     */
    protected $table = 'corso_di_studi'; 

    /**
     * Flag referente i timestamps nelle tabelle
     * 
     * @var bool
     */
    public $timestamps = false; 
}
