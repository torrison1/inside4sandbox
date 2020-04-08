<?php

namespace Inside4\CommonCore;

Class Response
{

    var $sessions;

    public function echo_json($response)
    {
        $response['new_token'] = $this->sessions->token;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}