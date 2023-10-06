<?php

namespace Aybarsm\Whmcs\Gateway\Yapikredi\Contracts;

interface PosnetRefundInterface
{
    public function __invoke(array $params);
}