<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDipartimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dipartimento', function (Blueprint $table) {

            /**
             * Identificativo progressivo 
             */
            $table->id(); 

            /**
             * Identificativo fornito dalla pagina unict QA
             */
            $table->integer('unict_id', false); 

            /**
             * Nome del dipartimento
             */
            $table->string('nome'); 

            /**
             * Anno accademico di inserimento
             */
            $table->string('anno_accademico');  

            /**
             * L'identificativo fornito dall'unict, insieme 
             * all'anno accademico, forniscono una chiave univoca
             * abbastanza scomoda da utilizzare. Tuttavia, è
             * necessario garantirne l'univocità. 
             */
            $table->unique(['unict_id', 'anno_accademico']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dipartimento');
    }
}
