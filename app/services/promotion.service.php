<?php
function showPromotionList($promotions, $stats) {
    RenderView("promotion/listePromotion", [
        'promotions' => $promotions,
        'stats' => $stats
    ], "base.layout");
}
