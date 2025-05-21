<?php
function showPromotionList($promotions, $stats, $pagination, $view) {
    $referentiels = findAllReferentiels();
    RenderView("promotion/listePromotion", [
        'promotions' => $promotions,
        'stats' => $stats,
        'referentiels' => $referentiels,
        'pagination' => $pagination,
        'view' => $view
    ], "base.layout");
}
