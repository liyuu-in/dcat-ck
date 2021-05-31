<?php

namespace Liyuu\DcatCK\Polyfill;

use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;

class CommandResolver extends \CKSource\CKFinder\CommandResolver implements ArgumentResolverInterface {}
