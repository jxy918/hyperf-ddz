<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Hyperf\HttpMessage\Cookie\Cookie;

class IndexController extends AbstractController
{
    /**
     * 用户信息
     * @var null
     */
    public $userinfo = [];

    public function index(RenderInterface $render)
    {
        if (!$this->_isLogin()) {
            return $this->response->redirect('/login');
        }
        //用户信息传递到客户端
        $info = $this->request->getCookieParams();
        $u = json_decode($info['USER_INFO'], true);
        return $render->render('index.html', $u);
    }

    public function login(RequestInterface $request, ResponseInterface $response, RenderInterface $render)
    {
        $action = $request->post('action');
        $account = $request->post('account');
        $tips = '';
        if ($action == 'login') {
            if (!empty($account)) {
                //注册登录
                $uinfo = array('account' => $account);
                $cookie = new Cookie('USER_INFO', json_encode($uinfo));
                $response = $response->withCookie($cookie);
                return $response->redirect('/');
            } else {
                $tips = '温馨提示：用户账号不能为空！';
            }
        }
        return $render->render('login.html', ['tips' => $tips]);
    }

    private function _isLogin()
    {
        $cookie_info = $this->request->getCookieParams();
        if (isset($cookie_info['USER_INFO'])) {
            $this->userinfo = json_decode($cookie_info['USER_INFO']);
            return true;
        } else {
            return false;
        }
    }
}