<?php

namespace App\Models;

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
}
