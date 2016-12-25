<?php
require_once __DIR__ . '/../view/view_logic.php';

if(!isset($_COOKIE["countdown"])){
    $_COOKIE["countdown"] = 0;
}

function handler() {

    //$birthday = new DateTime('2016-12-17', new DateTimeZone('Europe/Berlin'));
    $birthday = new DateTime('', new DateTimeZone('Europe/Berlin'));
    $birthday->add(new DateInterval('PT15S'));
    $today = new DateTime('',new DateTimeZone('Europe/Berlin'));
    $recovery = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($recovery);

    $isAfterBirthday = 0;
    if ($today >= $birthday || $recovery[0] == 'force' || $_COOKIE["countdown"] == 1){
        $isAfterBirthday = 1;
        setcookie("countdown", 0);
    }


    switch ($isAfterBirthday) {
        case 1:
            return_view('BIRTHDAY', null);
            break;
        case 0:
            $diff = $birthday->getTimestamp() - $today->getTimestamp();
            return_view('COUNTDOWN', $diff);
            break;
        default :
            echo "no disponible";
            return_view('404');
    }
}

handler();