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
            $table->string('anno_accademico', 10);

            /**
             * Anno a partire dal quale si ha accesso all'insegnamento
             */
            $table->string('anno', 4);

            /**
             * Semestre di appartenenza
             */
            $table->string('semestre', 4);

            /**
             * crediti assegnati alla materia
             */
            $table->string('cfu', 2);

            /**
             * docente assegnato alla materia
             */
            $table->string('docente', 100)
                ->nullable()
                ->default(NULL);

            /**
             * Nel caso il corso sia suddiviso in canali,
             * si riporta il canale di riferimento
             */
            $table->string('canale', 6)
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
            $table->string('nome_modulo', 100)
                ->nullable()
                ->default(null);

            /**
             * ??
             */
            $table->string('tipo', 4)
                ->nullable()
                ->default(NULL);

            /**
             * campo di ricerca
             */
            $table->string('ssd', 100)
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

            // $table->foreign('id_cds')
            //     ->references('id')->on('corso_di_studi');

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
                'canale',
                'id_cds',
                'anno',
                'docente',
                'assegn',
                'tipo',
            ], 'unique_ins');
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
