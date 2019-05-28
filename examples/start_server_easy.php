<?php

use ESD\Plugins\Session\SessionPlugin;
use ESD\Server\Co\ExampleClass\DefaultServer;
use ESD\Server\Co\ExampleClass\Port\DefaultPort;
use ESD\Server\Co\ExampleClass\Process\DefaultProcess;

require __DIR__ . '/../vendor/autoload.php';

define("ROOT_DIR", __DIR__ . "/..");
define("RES_DIR", __DIR__ . "/resources");
$server = new DefaultServer(null, DefaultPort::class, DefaultProcess::class);
$server->getPlugManager()->addPlug(new SessionPlugin());
//配置
$server->configure();
//启动
$server->start();
