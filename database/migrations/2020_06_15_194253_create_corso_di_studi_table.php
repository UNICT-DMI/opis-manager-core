<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorsoDiStudiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corso_di_studi', function (Blueprint $table) {

            /**
             * Identificativo progressivo 
             */
            $table->id(); 

            /**
             * Identificativo fornito dalla pagina unict QA
             */
            $table->integer('unict_id', false);

            /**
             * Nome del corso di studi
             */
            $table->string('nome'); 

            /**
             * Anno accademico di inserimento
             */
            $table->string('anno_accademico');  

            /**
             * Identificativo del dipartimento di appartenenza
             */
            $table->unsignedBigInteger('id_dipartimento'); 

            $table->foreign('id_dipartimento')
                ->references('id')->on('dipartimento'); 

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
        Schema::dropIfExists('corso_di_studi');
    }
}
