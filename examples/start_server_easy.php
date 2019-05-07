<?php

use GoSwoole\BaseServer\ExampleClass\Server\DefaultServer;
use GoSwoole\Plugins\Aop\AopConfig;
use GoSwoole\Plugins\Aop\AopPlugin;
use GoSwoole\Plugins\EasyRoute\EasyRoutePlugin;
use GoSwoole\Plugins\Session\SessionPlugin;

require __DIR__ . '/../vendor/autoload.php';

define("ROOT_DIR", __DIR__ . "/..");
define("RES_DIR", __DIR__ . "/resources");
$server = new DefaultServer();
$server->getPlugManager()->addPlug(new SessionPlugin());
//配置
$server->configure();
//启动
$server->start();
