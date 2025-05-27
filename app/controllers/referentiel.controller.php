<?php
require_once "../app/boostrap/boostrap.php";
if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
    $errors = [];

    if ($page == "listeReferentiel") {
        $referentiels = findAllReferentiels();
        $stats = getReferentielStats();
        RenderView("referentiel/listereferentiel", [
            'referentiels' => $referentiels,
            'stats' => $stats
        ], "base.layout");
    } elseif ($page == "add") {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelle = trim($_POST["libelle"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $capacite = trim($_POST["capacite"] ?? '');
            
            // Traitement de l'image
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors["image"] = "Le format de l'image n'est pas valide. Formats acceptés : JPG, PNG, GIF.";
                } elseif ($_FILES['image']['size'] > $maxSize) {
                    $errors["image"] = "L'image ne doit pas dépasser 5MB.";
                } else {
                    $image = $_FILES['image'];
                }
            } else {
                $errors["image"] = "L'image est obligatoire.";
            }

            if (empty($libelle)) {
                $errors["libelle"] = "Le libellé est obligatoire.";
            }
            if (empty($description)) {
                $errors["description"] = "La description est obligatoire.";
            }
            if (empty($capacite)) {
                $errors["capacite"] = "La capacité est obligatoire.";
            } elseif (!is_numeric($capacite) || $capacite <= 0) {
                $errors["capacite"] = "La capacité doit être un nombre positif.";
            }

            if (empty($errors)) {
                $success = addReferentiel($libelle, $description, $capacite, $image);
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