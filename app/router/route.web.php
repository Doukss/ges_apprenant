<?php
session_start();
define ("WEBROOB","http://malick.mbodji.ecole221.sn:8000/?");
require_once "../app/models/model.php";

function route() {
    $controllers = [
        "promotion" => "../app/controllers/promotion.controller.php",
        "login" => "../app/controllers/login.controller.php",
        "referentiel" => "../app/controllers/referentiel.controller.php",
        "apprenant" => "../app/controllers/apprenant.controller.php"
    ];

    $controller = $_GET["controllers"] ?? "login";
    $controllerFile = $controllers[$controller] ?? null;

    $isValidController = $controllerFile !== null;
    $isAuthenticated = isset($_SESSION["utilisateur"]);

    echo $isValidController
        ? ($isAuthenticated || $controller === "login"
            ? require_once $controllerFile
            : header("Location: " . WEBROOB . "?controllers=login"))
        : exit("Contrôleur inexistant");
}

