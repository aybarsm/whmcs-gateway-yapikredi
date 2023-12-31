<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once dirname(__DIR__,3) . DIRECTORY_SEPARATOR . 'autoload.php';

use Aybarsm\Whmcs\Gateway\Yapikredi\Posnet;

function yapikredi_MetaData(): array
{
    return Posnet::getMetaData();
}

function yapikredi_config(): array
{
    return Posnet::getSettings();
}

if (Posnet::isRefundEnabled()){
    function yapikredi_refund($params): array
    {
        return Posnet::refund($params);
    }
}

function yapikredi_3dsecure(array $params): string
{
    return Posnet::paymentAttempt($params);
}

function yapikredi_TransactionInformation(array $params = [])
{
    return Posnet::getTransactionInformationByParamsViaHistory($params);
}