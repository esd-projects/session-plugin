<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/7
 * Time: 14:48
 */

namespace GoSwoole\Plugins\Session;


use GoSwoole\BaseServer\Server\Beans\Request;
use GoSwoole\BaseServer\Server\Beans\Response;
use GoSwoole\BaseServer\Server\Server;

class HttpSession
{
    /**
     * @var bool
     */
    protected $isNew;

    protected $attribute;

    /**
     * @var string
     */
    protected $id;
    /**
     * @var SessionStorage
     */
    protected $sessionStorage;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;


    /**
     * @var SessionConfig
     */
    protected $config;

    public function __construct()
    {
        $plug = Server::$instance->getPlugManager()->getPlug(SessionPlugin::class);
        if ($plug instanceof SessionPlugin) {
            $this->sessionStorage = $plug->getSessionStorage();
        }
        $this->config = Server::$instance->getContainer()->get(SessionConfig::class);
        setContextValue("HttpSession", $this);
        $this->request = getDeepContextValueByClassName(Request::class);
        $this->response = getDeepContextValueByClassName(Response::class);
        $this->id = $this->request->getCookie($this->config->getSessionName());
        if ($this->id != null) {
            $this->isNew = false;
            $result = $this->sessionStorage->get($this->id);
            if ($result != null) {
                $this->attribute = serverUnSerialize($result);
            } else {
                $this->attribute = [];
            }
        }
        defer(function () {
            $this->save();
        });
    }

    public function refresh()
    {
        $this->id = $this->gid();
        $this->response->addCookie($this->config->getSessionName(), $this->id, time() + $this->config->getTimeout(),
            $this->config->getPath(), $this->config->getDomain(), $this->config->getSecure(), $this->config->getHttpOnly());
        $this->isNew = true;
        $this->setAttribute("createTime", time());
    }

    /**
     * 是否可用
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isExist() && !$this->isOverdue();
    }

    /**
     * 是否过期
     * @return bool
     */
    public function isOverdue(): bool
    {
        if (empty($this->attribute)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否存在
     * @return bool
     */
    public function isExist(): bool
    {
        if ($this->id != null) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->isNew;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setAttribute(string $key, $value): void
    {
        $this->attribute[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function removeAttribute(string $key): void
    {
        unset($this->attribute[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key)
    {
        return $this->attribute[$key] ?? null;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    public function save()
    {
        if (!empty($this->attribute) && $this->id != null) {
            $this->sessionStorage->set($this->id, serverSerialize($this->attribute));
        }
    }

    public function invalidate()
    {
        if ($this->id != null) {
            $this->sessionStorage->remove($this->id);
            $this->response->addCookie("SESSIONID", "");
        }
        $this->id = null;
        $this->attribute = [];
    }

    private function gid()
    {
        return session_create_id();
    }
}