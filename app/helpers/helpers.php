<?php

function colorState($state){
    switch ($state) {
        case 'Actif':
            return 'success';
            break;
        case 'Inactif':
            return 'error';
            break;
        default:
            return 'warning';
        break;
    }
}