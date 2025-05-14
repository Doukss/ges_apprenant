<?php
require_once "../app/boostrap/boostrap.php";

if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
    $errors = [];


    if ($page == "login") {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            RenderView("security/login", [], "security.layout");
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $email = trim($_POST["email"] ?? '');
            $mot_de_passe = trim($_POST["mot_de_passe"] ?? '');

            if (empty($email)) {
                $errors["email"] = "L'email est obligatoire.";
            }
            if (empty($mot_de_passe)) {
                $errors["mot_de_passe"] = "Le mot de passe est obligatoire.";
            }
            if (empty($errors)) {
                    $user = findUserConnect($email, $mot_de_passe);
                    

                if ($user) {
                     
                    $_SESSION["utilisateur"] = $user; 
                    switch ($user['role']) {
                        case 'admin':
                            header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");
                            break;
    
                        default:
                            header("Location: " . WEBROOB . "?controler=dashboard&page=dashboard");
                            break;
                    }
                } else {
                    $errors["email"] = "Email ou mot de passe incorrect.";
                }
            }
            RenderView("security/login", ["errors" => $errors], "security.layout");
            exit;
        }
    } elseif ($page == "deconnexion") {
        session_unset();
        session_destroy();
        header("Location:" . WEBROOB);
        exit;
    }
}
RenderView("security/login", [], "security.layout");
