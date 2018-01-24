<?php
ob_start("ob_gzhandler");


require_once 'inc/boot.php';

// sitemap cache
$sitemap_cache = DIR_VHOST_CACHE.'sitemap.xml';

// set 2 hours cache, must be replace by an hook or something else...
if (file_exists($sitemap_cache) && filemtime($sitemap_cache) > time()-(7200)) {
    $cached = file_get_contents($sitemap_cache);
    if ($cached !== false) {
        header('Content-Type: text/xml; charset=UTF-8');
        echo $cached;
        exit();
    }
}


$filename = isset( $_GET[ 'css' ] ) ? $_GET[ 'css' ] : '';
if( !$filename || !is_file($filename)) {
    die( 'Invalid Parameters' );
}


$contents = file_get_contents($filename);
echo minifycss($contents);


function minifycss($css) {
    header('Content-type: text/css');
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    $css = str_replace(', ', ',', $css);
    $css = str_replace(' ,', ',', $css);

    $css = str_replace('{ ', '{', $css);
    $css = str_replace('} ', '}', $css);
    $css = str_replace(' {', '{', $css);
    $css = str_replace(' }', '}', $css);
    $css = str_replace(';}', '}', $css);

    $css = trim($css);
    return $css;
}

//https://manas.tungare.name/software/css-compression-in-php/
//http://www.lafermeduweb.net/billet/creez-un-minifier-reducteur-de-code-css-en-php-581.html
// <link rel="stylesheet" type="text/css" file="minify.php?css=styles.css" />
?>
