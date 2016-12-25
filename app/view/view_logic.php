<?php

function return_view($event, $seconds) {

    $replacement = get_replacement($event, $seconds);
    $html = get_media('html', 'base');
    $html = render_dinamic_data($html, $replacement);
    print $html;
}

function get_replacement($event, $seconds) {
    switch ($event) {
        case 'BIRTHDAY':

            $data = array(
                'CSS' => '<link rel="stylesheet" type="text/css" href="/public/css/style.css">'
                , 'SUBTITLE' => 'Moltíssimes felicitats!'
                , 'BODY' => get_media('html', 'BIRTHDAY')
            );
            break;
        case 'COUNTDOWN':
            $data = array(
                'CSS' => '<link rel="stylesheet" type="text/css" href="/public/css/style.css">'
                , 'SUBTITLE' => 'Hauràs d\'esperar al teu aniversari...'
                , 'BODY' => get_media('html', 'COUNTDOWN')
                , 'JS' => '<script>' . build_js($seconds) . '</script>'
            );
            break;
        case '404':
            $data = array(
                'SUBTITLE' => 'ERROR 404'
                , 'BODY' => 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found on this server.'
            );
            break;
    }
    return $data;
}

function get_media($file_type, $name_file) {
    $file = __DIR__ . '/../view/site_media/' . $file_type . '/' . $name_file . '.' . $file_type;
    $template = file_get_contents($file);
    return $template;
}

function build_js($seconds) {
    $script = get_media('js', 'countdown');
    $script = str_replace("'{SEC}'", $seconds, $script);
    return $script;
}

function render_dinamic_data($html, $data) {

    foreach ($data as $key => $value) {
        $html = str_replace('{' . $key . '}', $value, $html);
    }

    $html = preg_replace(array('/<\w*>{\w*}<\/\w*>/', '/{\w*}/'), '', $html);

    return $html;
}