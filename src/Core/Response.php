<?php

namespace Chidori\Foundation\Core;

class Response
{
    public function __construct(public $body = '', public $status = 200, public array $headers = []) {}

    public function send(): void {

        // send headers
        foreach ($this->headers as $header) {
            header($header);
        }

        // set status
        http_response_code($this->status);

        // send body
        if(ob_get_contents()) {
            ob_end_clean();
        } else {
            echo $this->body;
        }

    }

}