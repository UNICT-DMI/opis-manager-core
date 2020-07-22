<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomandaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Domande contenute nelle schede opis con il loro
         * relativo peso standard. L'id indica l'identificativo
         * numerico assegnato alla domanda. 
         */
        Schema::create('domanda', function (Blueprint $table) {
            
            $table->smallInteger('id', 4);   
            $table->float('peso_standard', 6, 2); 
            $table->string('gruppo')->nullable()->default(null); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domanda');
    }
}
