<?php
require_once "../app/boostrap/boostrap.php";

$page = $_REQUEST["page"];
switch ($page) {
    
    case "listePromotion":
        $search = $_GET['search'] ?? '';
        $promotions = findAllPromotion($search);
        $stats = getDashboardStat();
        showPromotionList($promotions, $stats);

        break;

        default:
        header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");     
        break;

    }
