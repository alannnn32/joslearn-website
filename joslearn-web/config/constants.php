<?php
// Konstanta sistem JosLearn.

if (!defined('BASE_URL')) {
    define('BASE_URL', '/joslearn-website/joslearn-web');
}

// true  = OTP & database dilewati (untuk menguji tampilan)
// false = alur asli (OTP + database)
if (!defined('DEV_MODE')) {
    define('DEV_MODE', true);
}
