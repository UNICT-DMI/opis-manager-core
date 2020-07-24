<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPesiDomandeToCds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corso_di_studi', function (Blueprint $table) {

            /**
             * Campo contenente i pesi delle domande dell'opis 
             * personalizzati per il singolo cdl. 
             */
            $table->json('pesi_domande')
                ->nullable()
                ->default(null); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corso_di_studi', function (Blueprint $table) {
            $table->dropColumn('pesi_domande'); 
        });
    }
}
