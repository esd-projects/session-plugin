<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/7
 * Time: 16:27
 */

namespace GoSwoole\Plugins\Session;


trait GetSession
{
    public function getSession(): HttpSession
    {
        $session = getDeepContextValueByClassName(HttpSession::class);
        if($session == null){
            return new HttpSession();
        }
    }
}