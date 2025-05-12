<?php
// promotion.controller.php
require_once "../app/models/promotion.model.php";
require_once "../app/models/model.php";
require_once "../app/services/promotion.service.php";

$page = $_REQUEST["page"];
switch ($page) {
    case "listePromotion":
        showPromotionList();
        break;

        default:
        header("Location: " . WEBROOB . "?controllers=promotion&page=listePromotion");     
        break;

    }
