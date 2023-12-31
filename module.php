<?php

$configFilePath = dirname(__DIR__, 4) . DIRECTORY_SEPARATOR . 'yapikredi.php';
$configFileContent = "<?php \n\nrequire_once implode(DIRECTORY_SEPARATOR, [__DIR__, basename(__FILE__, '.php'), 'vendor', 'aybarsm', 'whmcs-gateway-yapikredi', 'functions', 'whmcs.module.config.php']);";
$configFileExists = file_exists($configFilePath);
$callbackFilePath = dirname(__DIR__, 4) . DIRECTORY_SEPARATOR . 'callback' . DIRECTORY_SEPARATOR . 'yapikredi.php';
$callbackFileContent = "<?php \n\nrequire_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), basename(__FILE__, '.php'), 'vendor', 'aybarsm', 'whmcs-gateway-yapikredi', 'functions', 'whmcs.module.callback.php']);";
$callbackFileExists = file_exists($callbackFilePath);
function consoleMessage(string $fileType, string $status, string $path){
    echo "Gateway module WHMCS {$fileType} file {$status}: {$path}\n";
}

if (($argv[1] ?? '') === 'install'){
    if (! $configFileExists){
        file_put_contents($configFilePath, $configFileContent);
    }
    consoleMessage('config', ($configFileExists ? 'already exists' : 'created'), $configFilePath);

    if (! $callbackFileExists){
        file_put_contents($callbackFilePath, $callbackFileContent);
    }
    consoleMessage('callback', ($callbackFileExists ? 'already exists' : 'created'), $configFilePath);
}elseif (($argv[1] ?? '') === 'uninstall'){
    if ($configFileExists){
        unlink($configFilePath);
    }
    consoleMessage('config', ($configFileExists ? 'deleted' : 'does not exist'), $configFilePath);

    if ($callbackFileExists){
        unlink($callbackFilePath);
    }
    consoleMessage('callback', ($callbackFileExists ? 'deleted' : 'does not exist'), $configFilePath);
}else {
    echo "Argument not found! Available arguments: install, uninstall\n";
}

