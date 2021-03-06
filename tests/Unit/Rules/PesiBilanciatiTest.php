<?php

namespace Tests\Unit\Rules;

use App\Rules\PesiBilanciati;
use PHPUnit\Framework\TestCase;

class PesiBilanciatiTest extends TestCase
{
    private $rule; 

    private $validJsonExample = <<<JSON
        [
            {"id":1,  "peso":0.7,"gruppo":"V1"},
            {"id":2,  "peso":0.3,"gruppo":"V1"},
            {"id":4,  "peso":0.1,"gruppo":"V2"},
            {"id":5,  "peso":0.3,"gruppo":"V2"},
            {"id":9,  "peso":0.3,"gruppo":"V2"},
            {"id":10, "peso":0.3,"gruppo":"V2"},
            {"id":3,  "peso":0.1,"gruppo":"V3"},
            {"id":6,  "peso":0.5,"gruppo":"V3"},
            {"id":7,  "peso":0.4,"gruppo":"V3"}
        ]
    JSON; 

    private $invalidJsonExample = <<<JSON
        [
            {"id":1,  "peso":0.9,"gruppo":"V1"},
            {"id":2,  "peso":0.3,"gruppo":"V1"},
            {"id":4,  "peso":0.1,"gruppo":"V2"},
            {"id":5,  "peso":0.3,"gruppo":"V2"},
            {"id":9,  "peso":0.4,"gruppo":"V2"},
            {"id":10, "peso":0.3,"gruppo":"V2"},
            {"id":3,  "peso":0.1,"gruppo":"V3"},
            {"id":6,  "peso":0.4,"gruppo":"V3"},
            {"id":7,  "peso":0.4,"gruppo":"V3"}
        ]
    JSON; 

    protected function setUp(): void
    {
        parent::setUp(); 

        $this->rule = new PesiBilanciati(); 
    }

    /** @test */
    public function invalid_json_with_greater_sum_than_one_must_not_pass(): void 
    {
        $this->assertFalse($this->rule->passes('pesi', $this->invalidJsonExample)); 
    }

    /** @test */
    public function valid_json_with_lesser_sum_than_one_must_pass(): void 
    {
        $this->assertTrue($this->rule->passes('pesi', $this->validJsonExample)); 
    }
    
}
