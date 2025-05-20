<?php
require_once "../app/boostrap/boostrap.php";

$page = $_REQUEST["page"] ?? '';


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
