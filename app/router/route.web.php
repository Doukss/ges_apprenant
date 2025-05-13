<?php
session_start();
define ("WEBROOB","http://malick.mbodji.ecole221.sn:8000/?");
require_once "../app/models/model.php";

function route (){
    $controllers=[
        "promotion"=>"../app/controllers/promotion.controller.php",
        "login"=>"../app/controllers/login.controller.php"
    ];
    
    if (isset($_GET["controllers"])) {
        $controller=$_GET["controllers"];
        if(array_key_exists($controller,$controllers)){
            
            if (isset($_SESSION["utilisateur"])) {
                require_once $controllers[$controller];
            }
    
            else{
                header("Location:".WEBROOB."?controllers=login");
            }
            
        }else{
            echo("Controler inexistant");
        }
    }else { 
            require_once "../app/controllers/login.controller.php";
            exit;
        }
    
}
