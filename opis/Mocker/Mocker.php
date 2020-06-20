<?php

namespace Opis\Mocker; 

use App\Models\CorsoDiStudi;
use App\Models\Dipartimento;
use App\Models\Insegnamento;

class Mocker 
{
    /**
     * parser used to retrieve mock data
     * 
     * @var \Opis\Mocker\Parser
     */
    private $parser = null;

    /**
     * singleton instance
     * 
     * @var \Opis\Mocker\Mocker
     */
    private static $instance = null;

    /**
     * Use factory method pattern and dependency injection
     * to inject the parser into the mocker 
     */
    private function __construct () {
        $this->parser = ParserFactory::get(); 
    }

    /**
     * Singleton get instance static method
     * 
     * @return \Opis\Mocker\Mocker
     */
    public static function getInstance(): Mocker
    {
        if (self::$instance == null) 
            self::$instance = new Mocker(); 
        
        return self::$instance; 
    }
   
    /**
     * insert the mock into the database
     *
     * @return void
     */
    public function run(): void 
    {
        $this->insertDipartimento(); 
        $this->insertCorsoDiStudi(); 
        $this->insertInsegnamenti(); 
    }
    
    /**
     * Insert dipartimento into the database
     *
     * @return void
     */
    private function insertDipartimento(): void
    {
        Dipartimento::create($this->parser->getDipartimento());
    }
    
    /**
     * Insert corso di studi into the database
     *
     * @return void
     */
    private function insertCorsoDiStudi(): void 
    {
        $corsoDiStudi = $this->parser->getCorsoDiStudi(); 
        $corsoDiStudi['id_dipartimento'] = $this->getDipartimentoProgressive();
        
        CorsoDiStudi::create($corsoDiStudi); 
    }
    
    /**
     * Insert insegnamenti into the database
     *
     * @return void
     */
    private function insertInsegnamenti(): void 
    {
        $idCds = $this->getCorsoDiStudiProgressive(); 

        foreach ($this->parser->getInsegnamenti() as $insegnamento) {
            $insegnamento['id_cds'] = $idCds; 
            Insegnamento::create($insegnamento); 
        }
    }

    /**
     * ritorna l'identificativo del dipartimento appena inserito
     * 
     * @return int 
     */
    private function getDipartimentoProgressive(): int 
    {
        $dipartimento = $this->parser->getDipartimento(); 

        return Dipartimento::where('unict_id', $dipartimento['unict_id'])
                    ->where('anno_accademico', $dipartimento['anno_accademico'])
                    ->first()->id;
    }

    /**
     * ritorna l'identificativo del corso di studi appena inserito
     * 
     * @return int 
     */
    private function getCorsoDiStudiProgressive(): int 
    {
        $corsoDiStudi = $this->parser->getCorsoDiStudi(); 

        return CorsoDiStudi::where('unict_id', $corsoDiStudi['unict_id'])
                ->where('anno_accademico', $corsoDiStudi['anno_accademico'])
                ->first()->id;
    }
}