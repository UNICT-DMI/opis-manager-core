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
}
