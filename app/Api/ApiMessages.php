<?php

namespace App\Api;

class ApiMessages
{       
    /**
     * message
     *
     * @var array
     */
    private $message = [];
        
    /**
     * Method __construct
     *
     * @param string $message [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(string $message, array $data = [])
    {
        $this->message['message'] = $message;
        $this->message['errors'] = $data;  
    }
    
    /**
     * Method getMessage
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }
}