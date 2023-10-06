<?php

namespace Aybarsm\Whmcs\Gateway\Yapikredi\Contracts;

interface PosnetPaymentInterface
{
    public function attempt(array $params);
    public function callback();

}