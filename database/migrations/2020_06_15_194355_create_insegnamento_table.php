<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nota: è importante che tutti i valori non definiti
 * assumano il valore NULL e non stringhe vuote, 'no',
 * 0 etc... per consistenza della base di dati e della
 * trattazione dei dati nel backend.
 */
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
            $table->string('anno_accademico', 20);

            /**
             * Anno a partire dal quale si ha accesso all'insegnamento
             */
            $table->string('anno', 10);

            /**
             * Semestre di appartenenza
             */
            $table->string('semestre', 60);

            /**
             * crediti assegnati alla materia
             */
            $table->string('cfu', 5);

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
            $table->string('canale', 8)
                ->default('no');

            /**
             * Nel caso l'insegnamento disponga di più moduli,
             * si riporta l'identificativo di riferimento
             */
            $table->string('id_modulo')
                ->default(0);

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
            $table->string('tipo', 25)
                ->nullable()
                ->default(NULL);

            /**
             * campo di ricerca
             */
            $table->string('ssd', 50)
                ->nullable()
                ->default(NULL);

            /**
             * ??
             */
            $table->string('assegn', 100)
                ->nullable()
                ->default(NULL);

            /**
             * Identificativo del corso di studi di appartenenza
             */
            $table->unsignedBigInteger('id_cds');

            $table->foreign('id_cds')
                ->references('id')->on('corso_di_studi');
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
