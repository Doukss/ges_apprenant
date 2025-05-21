<?php
require_once "../app/boostrap/boostrap.php";
require_once "../app/models/referentiel.model.php";

if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
    $errors = [];

    if ($page == "listeReferentiel") {
        $referentiels = findAllReferentiels();
        $stats = getReferentielStats();
        RenderView("referentiel/listeReferentiel", [
            'referentiels' => $referentiels,
            'stats' => $stats
        ], "base.layout");
    } elseif ($page == "add") {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelle = trim($_POST["libelle"] ?? '');
            $description = trim($_POST["description"] ?? '');

            if (empty($libelle)) {
                $errors["libelle"] = "Le libellé est obligatoire.";
            }
            if (empty($description)) {
                $errors["description"] = "La description est obligatoire.";
            }

            if (empty($errors)) {
                $success = addReferentiel($libelle, $description);
                if ($success) {
                    header("Location: " . WEBROOB . "?controllers=referentiel&page=listeReferentiel");
                    exit;
                } else {
                    $errors["general"] = "Une erreur est survenue lors de l'ajout du référentiel.";
                }
            }
            RenderView("referentiel/listeReferentiel", [
                'errors' => $errors,
                'form_data' => $_POST
            ], "base.layout");
        }
    }
} 