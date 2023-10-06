<?php

require_once dirname(__DIR__,7) . DIRECTORY_SEPARATOR . 'init.php';
require_once dirname(__DIR__,3) . DIRECTORY_SEPARATOR . 'autoload.php';

Aybarsm\Whmcs\Gateway\Yapikredi\Posnet::paymentCallback();