
<?php
define('QR_ECLEVEL_L', 0);
define('QR_ECLEVEL_M', 1);
define('QR_ECLEVEL_Q', 2);
define('QR_ECLEVEL_H', 3);

class QRcode {
    public static function png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 4, $margin = 4) {
        include_once __DIR__ . '/vendor/qrlib/qrlib.php';
        \QRcode::png($text, $outfile, $level, $size, $margin);
    }
}
?>
