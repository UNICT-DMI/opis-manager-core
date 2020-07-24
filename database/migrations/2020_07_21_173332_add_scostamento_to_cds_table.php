<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScostamentoToCdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corso_di_studi', function (Blueprint $table) {
            
            $defaultScostamentoNumerosita = config('opis.scostamento.numerosita_schede'); 
            $defaultScostamentoMedia      = config('opis.scostamento.media_di_valutazione'); 

            $table->float('scostamento_numerosita', '10', '2')
                ->default($defaultScostamentoNumerosita); 

            $table->float('scostamento_media', '10', '2')
                ->default($defaultScostamentoMedia); 

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
            $table->dropColumn([
                'scostamento_numerosita', 
                'scostamento_media'
            ]); 
        });
    }
}
