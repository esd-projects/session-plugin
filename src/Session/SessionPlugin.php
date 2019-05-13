<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/7
 * Time: 14:33
 */

namespace GoSwoole\Plugins\Session;

use GoSwoole\BaseServer\Server\Context;
use GoSwoole\BaseServer\Server\PlugIn\AbstractPlugin;
use GoSwoole\BaseServer\Server\PlugIn\PluginInterfaceManager;
use GoSwoole\Plugins\Redis\RedisPlugin;

class SessionPlugin extends AbstractPlugin
{

    /**
     * @var SessionConfig
     */
    private $sessionConfig;

    /**
     * @var SessionStorage
     */
    protected $sessionStorage;

    /**
     * SessionPlugin constructor.
     * @param SessionConfig|null $sessionConfig
     * @throws \DI\DependencyException
     * @throws \ReflectionException
     */
    public function __construct(?SessionConfig $sessionConfig = null)
    {
        parent::__construct();
        $this->atAfter(RedisPlugin::class);
        if ($sessionConfig == null) {
            $sessionConfig = new SessionConfig();
        }
        $this->sessionConfig = $sessionConfig;
    }

    /**
     * @param PluginInterfaceManager $pluginInterfaceManager
     * @return mixed|void
     * @throws \DI\DependencyException
     * @throws \GoSwoole\BaseServer\Exception
     */
    public function onAdded(PluginInterfaceManager $pluginInterfaceManager)
    {
        parent::onAdded($pluginInterfaceManager);
        $pluginInterfaceManager->addPlug(new RedisPlugin());
    }

    /**
     * 获取插件名字
     * @return string
     */
    public function getName(): string
    {
        return "Session";
    }

    /**
     * 在服务启动前
     * @param Context $context
     * @return mixed
     * @throws \GoSwoole\BaseServer\Server\Exception\ConfigException
     */
    public function beforeServerStart(Context $context)
    {
        $this->sessionConfig->merge();
        $class = $this->sessionConfig->getSessionStorageClass();
        $this->sessionStorage = new $class($this->sessionConfig);
        $this->setToDIContainer(SessionStorage::class, $this->sessionStorage);
        $this->setToDIContainer(HttpSession::class, new HttpSessionProxy());
        return;
    }

    /**
     * 在进程启动前
     * @param Context $context
     * @return mixed
     */
    public function beforeProcessStart(Context $context)
    {
        $this->ready();
    }

    /**
     * @return SessionStorage
     */
    public function getSessionStorage(): SessionStorage
    {
        return $this->sessionStorage;
    }
}