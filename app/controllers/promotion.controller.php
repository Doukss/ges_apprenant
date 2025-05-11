<?php
verifyUserAuth();
require_once "../boostrap/required.php";





$page = isset($_GET["page"]) ? $_GET["page"] : "dashboard";
$role = $_SESSION["user"]["role_name"];
$data = ["role" => $role, "page" => $page];

switch ($page) {
    case 'dashboard':
       
        renderView("administrateur/dashboard", $data, "dashboard");
        break;
    case 'promotion':

            renderView("administrateur/professeur", $data, "dashboard");
            break;
    default:
        redirection("notFound", "error");
        break;
}
