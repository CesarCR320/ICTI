
<?php
/*
 * PHP QR Code encoder
 * http://phpqrcode.sourceforge.net/
 * 
 * This library is free software, distributed under the LGPL.
 * 
 * Modified and stripped for minimal use
 */

function QRcode_output($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 4, $margin = 4) {
    include_once dirname(__FILE__).'/qrconst.php';
    include_once dirname(__FILE__).'/qrtools.php';
    include_once dirname(__FILE__).'/qrspec.php';
    include_once dirname(__FILE__).'/qrinput.php';
    include_once dirname(__FILE__).'/bitstream.php';
    include_once dirname(__FILE__).'/qrimage.php';
    include_once dirname(__FILE__).'/split.php';
    include_once dirname(__FILE__).'/mask.php';
    include_once dirname(__FILE__).'/qrencode.php';

    QRimage::png($text, $outfile, $level, $size, $margin);
}
?>
