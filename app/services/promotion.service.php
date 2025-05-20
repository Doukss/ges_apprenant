<?php
function showPromotionList($promotions, $stats) {
    $referentiels = findAllReferentiels();
    RenderView("promotion/listePromotion", [
        'promotions' => $promotions,
        'stats' => $stats,
        'referentiels' => $referentiels
    ], "base.layout");
}
