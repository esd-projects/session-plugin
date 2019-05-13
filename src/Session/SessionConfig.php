<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/7
 * Time: 14:41
 */

namespace ESD\Plugins\Session;


use ESD\BaseServer\Plugins\Config\BaseConfig;

class SessionConfig extends BaseConfig
{
    const key = "session";

    /**
     * 销毁时间s
     * @var int
     */
    protected $timeout = 30 * 60;

    /**
     * @var string
     */
    protected $db = "default";
    /**
     * @var string
     */
    protected $sessionStorageClass = RedisSessionStorage::class;

    /**
     * @var string
     */
    protected $domain = '';


    /**
     * @var string
     */
    protected $path = '/';

    /**
     * @var string
     */
    protected $sessionName = 'SESSIONID';


    /**
     * @var bool
     */
    protected $httpOnly = true;


    /**
     * 是否仅ssl
     * @var bool
     */
    protected $secure = false;


    public function __construct()
    {
        parent::__construct(self::key);
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getSessionStorageClass(): string
    {
        return $this->sessionStorageClass;
    }

    /**
     * @param string $sessionStorageClass
     */
    public function setSessionStorageClass(string $sessionStorageClass): void
    {
        $this->sessionStorageClass = $sessionStorageClass;
    }


    public function getSecure(): bool
    {
        return $this->secure;
    }

    public function setSecure(bool $secure): void {
        $this->secure = $secure;
    }


    /**
     * @return string
     */
    public function getDomain():string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path) :void
    {
        $this->path = $path;
    }


    /**
     * @return bool
     */
    public function getHttpOnly():bool
    {
        return $this->httpOnly;
    }


    /**
     * @param bool $bool
     */
    public function setHttpOnly(bool $bool): void
    {
        $this->httpOnly = $bool;
    }


    /**
     * @return string
     */
    public function getSessionName(): string
    {
        return $this->sessionName;
    }

    /**
     * @param string $name
     */
    public function setSessionName(string $name): void
    {
        $this->sessionName = $name;
    }






    /**
     * @return string
     */
    public function getDb(): string
    {
        return $this->db;
    }

    /**
     * @param string $db
     */
    public function setDb(string $db): void
    {
        $this->db = $db;
    }
}