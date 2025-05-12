<?php
function showPromotionList() {
        $promotions = findAllPromotion(); 
        $stats = getDashboardStat();
        
        RenderView("promotion/listePromotion", [
            'promotions' => $promotions,
            'stats' => $stats
        ], "base.layout");
    }