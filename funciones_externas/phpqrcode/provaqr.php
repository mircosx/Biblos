<?php

function qrgen($data) {
    include "/phpqrcode/qrlib.php";
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    $errorCorrectionLevel = 'H';
    $matrixPointSize = '4';

    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

    $filename = $PNG_TEMP_DIR . 'test.png';

    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" />';
}

?>
