<?php

return function($container){

    $container->set("settings", function(){
        return [
            "displayErrorDetails" => true,
            "logErrorDetails" => true,
            "logErrors" => true
        ];
    });

}

?>