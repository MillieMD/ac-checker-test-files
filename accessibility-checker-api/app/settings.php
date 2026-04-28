<?php

return function($container){

    $container->set("settings", function(){
        return [
            "displayErrorDetails" => false,
            "logErrorDetails" => true,
            "logErrors" => true
        ];
    });

}

?>