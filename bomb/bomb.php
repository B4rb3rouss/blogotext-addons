<?php

/**
 * Changelog
 *
 * 1.0.0 2018-01-29
 *   implement bomb https://blog.haschek.at/2017/how-to-defend-your-website-with-zip-bombs.html
 */
 
$declaration = array(
    // the tag of your addon (required)
    'tag' => 'bomb',

    // the name, showed in admin/addon (required)
    'name' => array(
        'en' => 'Bomb',
        'fr' => 'Bombe'
    ),

    // the desc, showed in admin/addon (required)
    'desc' => array(
        'en' => 'trap for bad bots',
        'fr' => 'piège pour les curieux'
    ),

    // the version, showed in admin/addon (required)
    'version' => '1.0.0',
    'compliancy' => '3.7',
    'url' => 'https://yeuxdelibad.net',
);

function a_bomb()
{
    return '<a rel="nofollow" style="display:none;" href="'.URL_ROOT.'addons/bomb/surprise.php">Do NOT follow this link or you will have problems!</a>';
}
