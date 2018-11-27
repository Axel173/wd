<?php

namespace app\controllers;

use app\models\AppModel;
use app\models\Personal;
use fw\base\Controller;


/**
 *
 * Description of App
 *
 */

class AppController extends Controller
{
    public $menu;
    public $meta = [];
    public $breadcrumbs;
    public $attributes;
    public $auth_required = array(
        'user_id' => '',
        'session_key' => ''
    );
    public $is_auth = false;

    public function __construct($route)
    {
        parent::__construct($route);
        //mail("alex310197@mail.ru", "My Subject", "Line 1\nLine 2\nLine 3");
        new AppModel();
        //\R::fancyDebug(true);
        //debug($route);

        //App::$app->setProperty('langs', Language::getLanguages());
        //App::$app->setProperty('lang', Language::getLanguage(App::$app->getProperty('langs')));
        //debug(App::$app->getProperties());

        if ($this->checkAuth()) {
            $this->is_auth = true;
        } else {
            $this->resetSession();
        }
    }

    /*protected function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }*/

    public function checkAuth()
    {
        if (isset($_SESSION['user'])) {
            foreach ($this->auth_required as $key => $value) {
                if (isset($_SESSION['user'][$key]))
                    $this->auth_required[$key] = $_SESSION['user'][$key];
            }
        } else {
            foreach ($this->auth_required as $key => $value) {
                if (isset($_COOKIE[$key]))
                    $this->auth_required[$key] = $_COOKIE[$key];
            }
        }
        if (array_search('', $this->auth_required) === false) {

            $personal = new Personal();
            $session = $personal->getUser($this->auth_required, 'sessions');
            if($session)
            {
                $user = $personal->getUser(array('id' => $session->user_id));
                if ($user) {
                    $_SESSION['user'] = $this->auth_required;
                    return true;
                }
            }
        }
        return false;
    }

    public function clearCookies($cookies)
    {
        foreach ($cookies as $key => $value) {
            setcookie($key, "", time() - 36000, "/");
        }
        return true;
    }

    public function setCookies($cookies)
    {
        foreach ($cookies as $key => $value) {
            setcookie($key, $value['value'], $value['expire'], $value['path']);
        }
        return true;
    }

    public function checkRecaptcha($recaptcha, $secret)
    {
        if (!$recaptcha) {
            return false;
            /*$this->errors['recaptcha'] = array(
                'Не пройдена капча',
            );*/
        } else {
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            $ip = $_SERVER['REMOTE_ADDR'];

            $url_data = $url . '?secret=' . $secret . '&response=' . $recaptcha . '&remoteip=' . $ip;
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $res = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($res);

            if ($res->success) {
                return true;
            }

            return false;
        }
    }

    public function setSession($user_id, $remember = array())
    {
        $session = \R::dispense('sessions');
        $key = generateSalt(); //назовем ее $key
        if (!empty($remember)) {
            $session->cookie_key = $key;
            //Пишем куки (имя куки, значение, время жизни - сейчас+месяц)
            $cookies = array(
                'session_key' => array(
                    'value' => $key,
                    'expire' => 0x7FFFFFFF,
                    'path' => '/'
                ),
            );
            foreach ($remember as $k => $v) {
                $cookies[$k] = array(
                    'value' => $v,
                    'expire' => 0x7FFFFFFF,
                    'path' => '/'
                );
            }
            $this->setCookies($cookies);

        }

        $session->session_key = $key;
        $session->ip = GetIP();
        $session->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $session->date = date('Y.m.d H:m:s');
        $session->user_id = $user_id;
        foreach ($this->attributes as $k => $v) {
            if ($k != 'password') $_SESSION['user'][$k] = $v;
        }

        $_SESSION['user']['session_key'] = $key;
        \R::store($session);
    }

    public function resetSession()
    {
        if (isset($_SESSION['user'])) {
            $personal = new Personal();
            if($user_session = $personal->getUser($this->auth_required, 'sessions'))
            {
                $session = \R::load('sessions', $user_session->id);
                $session->cookie_key = "";
                $session->session_key = "";
                \R::store($session);
            }
            unset($_SESSION['user']);
        }
        $this->clearCookies($this->auth_required);
    }
}