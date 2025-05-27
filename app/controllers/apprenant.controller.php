<?php
// controllers/apprenant.controller.php
require_once "../app/boostrap/boostrap.php";

if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"];
    $errors = [];

    switch ($page) {
        case "listeApprenants":
            $filters = [
                'matricule' => $_GET['matricule'] ?? '',
                'classe' => $_GET['classe'] ?? '',
                'statut' => $_GET['statut'] ?? ''
            ];
            $currentPage = $_GET['p'] ?? 1;
            $perPage = 10;

            $apprenants = findAllApprenants($filters, $currentPage, $perPage);
            $total = countApprenants($filters);

            if (isset($_GET['export'])) {
                if ($_GET['export'] == 'pdf') {
                    exportApprenantsPDF($apprenants);
                } elseif ($_GET['export'] == 'excel') {
                    exportApprenantsExcel($apprenants);
                }
            }

            RenderView("apprenants/listeApprenants", [
                'apprenants' => $apprenants,
                'total' => $total,
                'currentPage' => $currentPage,
                'perPage' => $perPage,
                'filters' => $filters
            ], "base.layout");
            break;

        case "ajouter":
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $matricule = trim($_POST["matricule"] ?? '');
                $nom = trim($_POST["nom"] ?? '');
                $prenom = trim($_POST["prenom"] ?? '');
                $email = trim($_POST["email"] ?? '');
                $telephone = trim($_POST["telephone"] ?? '');
                $classe = trim($_POST["classe"] ?? '');
                $statut = trim($_POST["statut"] ?? '');
                
                // Validation des champs
                if (empty($matricule)) $errors["matricule"] = "Le matricule est obligatoire";
                if (empty($nom)) $errors["nom"] = "Le nom est obligatoire";
                if (empty($prenom)) $errors["prenom"] = "Le prénom est obligatoire";
                if (empty($email)) $errors["email"] = "L'email est obligatoire";
                if (empty($telephone)) $errors["telephone"] = "Le téléphone est obligatoire";
                if (empty($classe)) $errors["classe"] = "La classe est obligatoire";
                if (empty($statut)) $errors["statut"] = "Le statut est obligatoire";

                // Gestion de la photo
                $photo = null;
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_size = 5 * 1024 * 1024; // 5MB

                    if (!in_array($_FILES['photo']['type'], $allowed_types)) {
                        $errors["photo"] = "Type de fichier non autorisé. Formats acceptés : JPG, PNG, GIF";
                    } elseif ($_FILES['photo']['size'] > $max_size) {
                        $errors["photo"] = "La taille du fichier dépasse la limite autorisée (5MB)";
                    } else {
                        $photo = file_get_contents($_FILES['photo']['tmp_name']);
                    }
                }

                if (empty($errors)) {
                    $success = addApprenant($matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo);
                    if ($success) {
                        $_SESSION['success'] = "Apprenant ajouté avec succès";
                        header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                        exit;
                    } else {
                        $errors["general"] = "Une erreur est survenue lors de l'ajout de l'apprenant";
                    }
                }
            }
            RenderView("apprenants/ajouterApprenant", ['errors' => $errors], "base.layout");
            break;

        case "modifier":
            $id = $_GET['id'] ?? null;
            if ($id) {
                $apprenant = getApprenantById($id);
                if ($apprenant) {
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $matricule = trim($_POST["matricule"] ?? '');
                        $nom = trim($_POST["nom"] ?? '');
                        $prenom = trim($_POST["prenom"] ?? '');
                        $email = trim($_POST["email"] ?? '');
                        $telephone = trim($_POST["telephone"] ?? '');
                        $classe = trim($_POST["classe"] ?? '');
                        $statut = trim($_POST["statut"] ?? '');
                        
                        // Validation des champs
                        if (empty($matricule)) $errors["matricule"] = "Le matricule est obligatoire";
                        if (empty($nom)) $errors["nom"] = "Le nom est obligatoire";
                        if (empty($prenom)) $errors["prenom"] = "Le prénom est obligatoire";
                        if (empty($email)) $errors["email"] = "L'email est obligatoire";
                        if (empty($telephone)) $errors["telephone"] = "Le téléphone est obligatoire";
                        if (empty($classe)) $errors["classe"] = "La classe est obligatoire";
                        if (empty($statut)) $errors["statut"] = "Le statut est obligatoire";

                        // Gestion de la photo
                        $photo = null;
                        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                            $max_size = 5 * 1024 * 1024; // 5MB

                            if (!in_array($_FILES['photo']['type'], $allowed_types)) {
                                $errors["photo"] = "Type de fichier non autorisé. Formats acceptés : JPG, PNG, GIF";
                            } elseif ($_FILES['photo']['size'] > $max_size) {
                                $errors["photo"] = "La taille du fichier dépasse la limite autorisée (5MB)";
                            } else {
                                $photo = file_get_contents($_FILES['photo']['tmp_name']);
                            }
                        }

                        if (empty($errors)) {
                            $success = updateApprenant($id, $matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo);
                            if ($success) {
                                $_SESSION['success'] = "Apprenant modifié avec succès";
                                header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                                exit;
                            } else {
                                $errors["general"] = "Une erreur est survenue lors de la modification de l'apprenant";
                            }
                        }
                    }
                    RenderView("apprenants/modifierApprenant", [
                        'apprenant' => $apprenant,
                        'errors' => $errors
                    ], "base.layout");
                } else {
                    $_SESSION['error'] = "Apprenant non trouvé";
                    header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                    exit;
                }
            }
            break;

        case "details":
            $id = $_GET['id'] ?? null;
            if ($id) {
                $apprenant = getApprenantById($id);
                if ($apprenant) {
                    RenderView("apprenants/detailsApprenant", ['apprenant' => $apprenant], "base.layout");
                } else {
                    $_SESSION['error'] = "Apprenant non trouvé";
                    header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                    exit;
                }
            }
            break;

        case "supprimer":
            $id = $_GET['id'] ?? null;
            if ($id) {
                if (deleteApprenant($id)) {
                    $_SESSION['success'] = "Apprenant supprimé avec succès";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de l'apprenant";
                }
                header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                exit;
            }
            break;

        case "changerStatut":
            $id = $_GET['id'] ?? null;
            if ($id) {
                $apprenant = getApprenantById($id);
                if ($apprenant) {
                    $nouveauStatut = $apprenant['statut'] === 'Actif' ? 'Inactif' : 'Actif';
                    if (updateApprenantStatut($id, $nouveauStatut)) {
                        $_SESSION['success'] = "Statut de l'apprenant mis à jour avec succès";
                    } else {
                        $_SESSION['error'] = "Erreur lors de la mise à jour du statut";
                    }
                } else {
                    $_SESSION['error'] = "Apprenant non trouvé";
                }
                header("Location: " . WEBROOB . "?controllers=apprenant&page=listeApprenants");
                exit;
            }
            break;
    }
}