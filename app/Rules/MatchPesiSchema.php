<?php

namespace App\Rules;

use JsonSchema\Validator;
use JsonSchema\SchemaStorage;
use JsonSchema\Constraints\Factory;
use Illuminate\Contracts\Validation\Rule;

class MatchPesiSchema implements Rule
{
    /**
     * Json schema per la validazione dell'array di pesi
     * in input. 
     * 
     * @var string 
     */
    protected $schema = <<<JSON
    {            
        "type": "array", 
        "items": {
            "type": "object", 
            "properties": {
                "id": { "type": "number" },
                "peso": { "type": "number" },
                "gruppo": { "type": ["string", "null"] }
            }, 
            "additionalProperties": false, 
            "required": ["id", "peso", "gruppo"]
        } 
    }
    JSON; 

    protected $jsonSchemaObject; 

    protected $jsonSchemaStorage; 

    protected $jsonValidator; 

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jsonSchemaObject = json_decode($this->schema); 
        $this->jsonSchemaStorage = new SchemaStorage(); 
        $this->jsonSchemaStorage->addSchema('file://mySchema', $this->jsonSchemaObject); 
        $this->jsonValidator = new Validator(new Factory($this->jsonSchemaStorage)); 
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $jsonDataToValidate = \json_decode($value); 
        $this->jsonValidator->validate($jsonDataToValidate, $this->jsonSchemaObject); 
        
        return $this->jsonValidator->isValid(); 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $errorMessage = ""; 
        foreach ($this->jsonValidator->getErrors() as $error)
            $errorMessage .= $error['property'] . " " . $error['message'] . ' \n'; 
        return $errorMessage;
    }
}
