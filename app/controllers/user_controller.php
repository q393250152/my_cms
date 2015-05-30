<?php
/**
 * Created by PhpStorm.
 * User: Auser
 * Date: 2015/6/12
 * Time: 15:29
 */
class UserController extends CommonController
{
    function login()
    {
        $this->display();
    }

    function register()
    {
        $this->display();
    }

    function create()
    {
        if ($_POST) {
            if ($this->model->create($_POST)) {
                $this->jump("index.php?control=user&action=login", "注册成功，请登录！");
            } else {
                $this->jump("index.php?control=user&action=register", "用户名已被注册，请重新注册！");
            }

        }
    }

    function do_login()
    {
        if ($_POST) {
            if ($this->model->do_login($_POST)) {
                $this->jump("index.php?control=admin&action=admin", "登录成功！");
            } else {
                $this->jump("index.php?control=user&action=login", "请检查帐号或密码是否正确！");
                exit;
            }
        }
    }
    function cancellation(){
        $this->clearSession();
        $this->jump("index.php?control=user&action=login","安全退出成功！");

    }
    function clear_cache(){
        $this->clearSession();
        $this->jump("index.php?control=user&action=login","清除缓存成功！");
    }
}