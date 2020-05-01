<?php

namespace Inside4\CommonCore;

Class Response
{

    var $sessions;

    //i--- Output method for JSON Response ; inside_core ; torrison ; 01.05.2020 ; 1 ---/
    public function echo_json($response)
    {
        $response['new_token'] = $this->sessions->token;
        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

}