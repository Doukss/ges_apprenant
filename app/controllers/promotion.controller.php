<?php
require_once "../app/boostrap/boostrap.php";

$page = $_REQUEST["page"] ?? '';
$action = $_REQUEST["action"] ?? '';

if ($action === 'add') {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $promotion = $_POST["promotion"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        $referentiel_id = $_POST["referentiel"];

        // Gestion de l'upload de la photo
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($_FILES['photo']['type'], $allowed_types)) {
                $_SESSION['error'] = "Type de fichier non autorisé. Formats acceptés : JPG, PNG, GIF";
                header("Location: " . WEBROOB . "?controllers=promotion&page=ajoutPromotion");
                exit;
            }

            if ($_FILES['photo']['size'] > $max_size) {
                $_SESSION['error'] = "La taille du fichier dépasse la limite autorisée (5MB)";
                header("Location: " . WEBROOB . "?controllers=promotion&page=ajoutPromotion");
                exit;
            }

            // Lire le contenu du fichier
            $photo = file_get_contents($_FILES['photo']['tmp_name']);
        }

        $db = connectToDatabase();
        try {
            $db->beginTransaction();

            // Insérer la promotion avec la photo
            $sql = "INSERT INTO promotion (nom, date_debut, date_fin, statut, photo) VALUES (:nom, :date_debut, :date_fin, 'Actif', :photo)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':nom' => $promotion,
                ':date_debut' => $date_debut,
                ':date_fin' => $date_fin,
                ':photo' => $photo
            ]);
            $promotion_id = $db->lastInsertId();

            // Lier la promotion au référentiel
            $sql = "INSERT INTO referentiel_promotion (id_promotion, id_referentiel) VALUES (:id_promotion, :id_referentiel)";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':id_promotion' => $promotion_id,
                ':id_referentiel' => $referentiel_id
            ]);

            $db->commit();
            $_SESSION['success'] = "Promotion ajoutée avec succès";
        } catch (PDOException $e) {
            $db->rollBack();
            $_SESSION['error'] = "Erreur lors de l'ajout de la promotion: " . $e->getMessage();
        }

        header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");
        exit;
    }
}

switch ($page) {
    case "ajoutPromotion":
        $referentiels = getAllReferentiels();
        require_once "../app/views/promotion/ajoutPromotion.html.php";
        break;

    case "modifierPromotion":
        $id = $_GET['id'] ?? null;
        if ($id) {
            $promotion = getPromotionById($id);
            $referentiels = getAllReferentiels();
            if ($promotion) {
                require_once "../app/views/promotion/modifierPromotion.html.php";
            } else {
                $_SESSION['error'] = "Promotion non trouvée";
                header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");
                exit;
            }
        }
        break;
    
    case "listePromotion":
        $search = $_GET['search'] ?? '';
        $promotions = findAllPromotion($search);
        $stats = getDashboardStat();
        showPromotionList($promotions, $stats);
        break;

    case "detailPromotion":
        $id = $_GET['id'] ?? null;
        if ($id) {
            $promotion = getPromotionById($id);
            if ($promotion) {
                require_once "../app/views/promotion/detailPromotion.html.php";
            } else {
                $_SESSION['error'] = "Promotion non trouvée";
                header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");
                exit;
            }
        }
        break;

    default:
        header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");     
        break;
}
