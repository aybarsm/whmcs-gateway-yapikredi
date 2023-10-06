<?php

namespace Aybarsm\Whmcs\Gateway\Yapikredi;


use Illuminate\Support\Arr;
use Aybarsm\Whmcs\Gateway\Yapikredi\Abstracts\AbstractPosnetContext;
use Aybarsm\Whmcs\Gateway\Yapikredi\Contracts\PosnetPaymentInterface;
use Aybarsm\Whmcs\Service\Whmcs as WhmcsService;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Context\Helper;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Context\Maker;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Context\Task;

class PosnetPayment extends AbstractPosnetContext implements PosnetPaymentInterface
{
    use Helper, Maker, Task;

    protected string $context = 'Payment';

    public function attempt(array $params)
    {
        parent::init();

        $this->setTask('3ds', $params);
        $this->handlePosnetRequest();
        if (! is_null($terminate = $this->handlePostValidationStage())) return $terminate;
    }

    public function callback()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            WhmcsService::redirectSystemUrl();
        }

        parent::init();

        $this->setTask('init');
        $this->makeValidator();
        if (! is_null($terminate = $this->handlePostValidationStage())) return $terminate;

        // Ready to load WHMCS params
        $this->setTask('confirm', parent::getParamsByXid(Arr::get($this->validator->validated(), 'Xid')));
        $this->handlePosnetRequest();
        if (! is_null($terminate = $this->handlePostValidationStage())) return $terminate;

        $this->setTask('finalise');
        $this->handlePosnetRequest();
        if (! is_null($terminate = $this->handlePostValidationStage())) return $terminate;
    }

}