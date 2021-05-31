<?php

namespace Liyuu\DcatCK;

use Dcat\Admin\Extension;

class DcatCk extends Extension
{

    const NAME = 'dcat-ck';

    protected $serviceProvider = DcatCkServiceProvider::class;

    protected $composer = __DIR__.'/../composer.json';

    protected $assets = __DIR__.'/../resources/assets';

    protected $views = __DIR__.'/../resources/views';

//    protected $lang = __DIR__.'/../resources/lang';

    protected $menu = [
        'title' => 'Dcatck',
        'path'  => 'dcat-ck',
        'icon'  => '',
    ];
}
