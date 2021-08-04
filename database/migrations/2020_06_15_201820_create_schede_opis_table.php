<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedeOpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schede_opis', function (Blueprint $table) {
            
            /**
             * Identificativo progressivo 
             */
            $table->id();
            
            /**
             * Anno accademico in cui le schede sono state compilate
             */
            $table->string('anno_accademico'); 

            /**
             * numero totale di schede di studenti frequentanti
             */
            $table->integer('totale_schede', false); 

            /**
             * numero totale di schede di studenti non frequentanti
             */
            $table->integer('totale_schede_nf', false); 

            /**
             * numero totale di studenti di sesso femminile 
             * e frequentanti che hanno compilato la scheda
             */
            $table->integer('femmine', false)->nullable(); 

            /**
             * numero totale di studenti di sesso femminile 
             * e non frequentanti che hanno compilato la scheda
             */
            $table->integer('femmine_nf', false)->nullable();

            /**
             * numero di studenti F.C. che hanno compilato 
             * la scheda
             */
            $table->integer('fc', false); 

            /**
             * numero di studenti inattivi e frequentanti
             * che hanno compilato la scheda
             */
            $table->integer('inatt', false)->nullable(); 

            /**
             * numero di studenti inattivi e frequentanti
             * che hanno compilato la scheda
             */
            $table->integer('inatt_nf', false); 

            /**
             * parametri statistici vari nullable
             */
            $table->json('eta')->nullable();
            $table->json('anno_iscr')->nullable();
            $table->json('num_studenti')->nullable();
            $table->json('ragg_uni')->nullable();
            $table->json('studio_gg')->nullable();
            $table->json('studio_tot')->nullable();

            /**
             * parametri statistici vari
             */
            $table->json('domande'); 
            $table->json('domande_nf'); 
            $table->json('motivo_nf'); 
            $table->json('sugg'); 
            $table->json('sugg_nf'); 

            /**
             * Identificativo dell'insegnamento a cui si riferiscono
             */
            $table->unsignedBigInteger('id_insegnamento'); 

            $table->foreign('id_insegnamento')
                ->references('id')->on('insegnamento'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schede_opis');
    }
}
