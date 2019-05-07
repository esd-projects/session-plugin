<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/7
 * Time: 14:41
 */

namespace GoSwoole\Plugins\Session;


use GoSwoole\BaseServer\Plugins\Config\BaseConfig;

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