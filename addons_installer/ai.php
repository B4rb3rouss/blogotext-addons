<?php


// FIXME
$repo = "http://yeuxdelibad.net/DL/blogotext-addons";
$index = "addons_list.txt";
$addons_dir = '../../addons';

function reload_page()
{
    header("Location: ./ai.php");
    die();
}

if (isset($_GET['install'])) {
    // download archive if available and unzip
    $url = $repo.'/'.$_GET['install'].'.zip';

    // download
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    if ($data === false) {
        echo 'error:' . curl_error($ch);
    }
    curl_close($ch);

    if (!is_dir($addons_dir)) {
        mkdir($addons_dir);
    }

    $addon_zip = $addons_dir.'/'.$_GET['install'].'.zip';
    $tmpfile = fopen($addon_zip, "w+");
    if (!$tmpfile) {
        die("problem saving".$addon_zip);
    }
    $write = fwrite($tmpfile, $data);
    if (!$write) {
        die("problem saving".$addon_zip);
    }
    fclose($tmpfile);

    // unzip
    $zip = new ZipArchive;
    $res = $zip->open($addon_zip);
    if ($res === true) {
        $zip->extractTo($addons_dir);
        $zip->close();
    } else {
        die('error when extracting zip!');
    }
    if (!is_file($addon_zip)) {
        unlink($addon_zip);
    }

    reload_page();
} else if (isset($_GET['remove'])) {
    $todeldir = $addons_dir.'/'.$_GET['remove'];
    array_map('unlink', glob("$todeldir/*.*"));
    rmdir($todeldir);
    reload_page();
} else {
    // show availables addons
    $handle = fopen($repo.'/'.$index, "r");

    $addons=array();

    while ($line = fgets($handle)) {
        $line=trim($line);
        $addons[]=$line;
    }
    fclose($handle);

    echo "<ul>\n";
    foreach ($addons as $a) {
        $a = explode(' ', $a);

        echo "<li>\n";
        echo $a[0].' - '. $a[1]. ' ';
        echo "<span style='float:right'>\n";
        if (is_dir($addons_dir.'/'.$a[0])) {
            echo "<a href='?install=".$a[0]."'>Réinstaller ou mettre à jour</a>";
            echo "- <a href='?remove=".$a[0]."'>Supprimer</a>";
        } else {
            echo "<a href='?install=".$a[0]."'>Installer</a>";
        }
        echo "</span>\n";
        echo "</li>\n";
    }
    echo "</ul>\n";
}
