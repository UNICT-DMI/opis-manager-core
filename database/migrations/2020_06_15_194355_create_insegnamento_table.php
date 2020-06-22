<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsegnamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insegnamento', function (Blueprint $table) {
            
            /**
             * Identificativo progressivo 
             */
            $table->id(); 
            
            /**
             * codice gomp dell'insegnamento
             */
            $table->integer('codice_gomp', false); 

            /**
             * Nome dell'insegnamento
             */
            $table->string('nome'); 

            /**
             * Anno accademico di inserimento
             */
            $table->string('anno_accademico');  
            
            /**
             * Anno a partire dal quale si ha accesso all'insegnamento
             */
            $table->string('anno'); 

            /**
             * Semestre di appartenenza 
             */
            $table->string('semestre'); 

            /**
             * crediti assegnati alla materia
             */
            $table->string('cfu'); 

            /**
             * docente assegnato alla materia
             */
            $table->string('docente')
                ->nullable()
                ->default(NULL);

            /**
             * Nel caso il corso sia suddiviso in canali, 
             * si riporta il canale di riferimento
             */
            $table->string('canale')
                ->nullable()
                ->default(''); 

            /**
             * Nel caso l'insegnamento disponga di più moduli, 
             * si riporta l'identificativo di riferimento
             */
            $table->string('id_modulo')
                ->nullable()
                ->default(null); 
            
            /**
             * Nel caso l'insegnamento disponga di più moduli, 
             * si riporta il nome modulo di riferimento
             */
            $table->string('nome_modulo')
                ->nullable()
                ->default(null); 
            
            /**
             * ??
             */
            $table->string('tipo')
                ->nullable()
                ->default(NULL); 
            
            /**
             * campo di ricerca 
             */
            $table->string('ssd')
                ->nullable()
                ->default(NULL); 

            /**
             * ??
             */
            $table->string('assegn')
                ->nullable()
                ->default(NULL); 

            /**
             * Identificativo del corso di studi di appartenenza
             */
            $table->unsignedBigInteger('id_cds'); 

            $table->foreign('id_cds')
                ->references('id')->on('corso_di_studi');

            /**
             * L'identificativo fornito dall'unict, insieme 
             * all'anno accademico, forniscono una chiave univoca
             * abbastanza scomoda da utilizzare. Tuttavia, è
             * necessario garantirne l'univocità. 
             */
            $table->unique([
                'codice_gomp', 
                'anno_accademico', 
                'id_modulo', 
                'canale'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insegnamento');
    }
}
