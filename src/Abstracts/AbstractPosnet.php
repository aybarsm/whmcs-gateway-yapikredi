<?php

namespace Aybarsm\Whmcs\Gateway\Yapikredi\Abstracts;

use Illuminate\Support\Traits\Macroable;

use Aybarsm\Whmcs\Gateway\Yapikredi\Contracts\PosnetInterface;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Config;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Helper;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\External;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Factory;
use Aybarsm\Whmcs\Gateway\Yapikredi\Traits\Whmcs;
use Aybarsm\Whmcs\Service\Whmcs as WhmcsService;

abstract class AbstractPosnet implements PosnetInterface
{
    use Macroable, Config, Helper, External, Factory, Whmcs;

    protected static string $identifier = 'yapikredi';
    protected static bool $init;
    protected static \Illuminate\Validation\Factory $validationFactory;

    protected static function init(): void
    {
        if (isset(static::$init)) {
            return;
        }

        WhmcsService::registerMacros();
        static::$validationFactory = static::makeValidationFactory();

        $adminLang = static::getConfig('module.whmcs.admin_lang', 'english');
        WhmcsService::addAdminLangResource(static::getResourcePath('lang/whmcs/admin/' . "{$adminLang}.php"), $adminLang);

        \App::load_function('gateway');
        \App::load_function('invoice');

        static::$init = true;
    }

}