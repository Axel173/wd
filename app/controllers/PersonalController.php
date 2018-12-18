<?php

namespace app\controllers;

use app\models\Personal;
use fw\base\View;
use fw\libs\VKAuth;
use PHPMailer\PHPMailer\PHPMailer;
use Valitron\Validator;

class PersonalController extends AppController
{
    public $attributes = [
        'user_id' => '',
        'name' => '',
        'surname' => '',
        'birthday' => '',
        'login' => '',
        'password' => '',
        'password_repeat' => '',
        'email' => '',
        'vk_id' => '',
        'vk_auth' => '',
        'avatar' => '',
        'confirm_code' => '',
        'token' => '',
        'created_at' => '',
    ];

    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['password_repeat'],
            ['email'],
        ],
        'not_different' => [
            ['password', 'password_repeat'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
            ['login', 4],
        ],
    ];

    public $labels = [
        'login' => 'Поле',
        'password' => 'Поле',
        'password_repeat' => 'Поле',
        'email' => 'Поле',
    ];

    public $errors = array();

    public function indexAction()
    {
        $this->setTitle('Workout :: Кабинет');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

    }

    public function regAction()
    {
        $this->setTitle('Workout :: Регистрация');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('reg');
            $data = array(
                'data' => array(
                    'type' => 'login',
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        }

        if (!empty($_POST)) {
            $personal = new Personal();
            $data = $_POST;
            $this->load($data);
            if (!$this->validate($data) || !$personal->checkUnique(['email' => trim($data['email']), 'login' => trim($data['login'])])) {
                if (isset($personal->errors['errors'])) $this->errors = $personal->errors['errors'];
                $this->setErrors($this->errors);
                $_SESSION['form_data'] = $data;
                $this->setErrorsTest($this->errors);
                /*$_SESSION['form_data']['errors'] = $this->errors;*/
                redirect();
            }

            $this->attributes['password'] = password_hash($this->attributes['password'], PASSWORD_DEFAULT);
            unset($this->attributes['password_repeat']);
            $this->attributes['confirm_code'] = md5($this->attributes['email'] . generateSalt());
            if ($personal->save('users', $this->attributes)) {
                $user = $personal->getUser(array(
                    'email' => $this->attributes['email']
                ));
                $this->attributes['user_id'] = $user->id;
                $remember = array();
                if (isset($_POST['remember'])) {
                    $remember = array('user_id' => $user->id);
                }

                $this->setSession($user->id, $remember);

                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                //Recipients
                $mail->setFrom(SITE_EMAIL, SITE_NAME);
                $mail->addAddress($this->attributes['email']);     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Пожалуйста, подтвердите Ваш Email адрес!';
                $mail->Body = 'Уважаемый пользователь! <br>
                    На WorkoutDiary был указан Ваш Email адрес. Если это сделали именно Вы, 
                    пожалуйста, подтвердите это, перейдя по этой ссылке: <br/>
                    <a href="' . PATH . 'personal/login/?email-confirmation=' . $this->attributes['confirm_code'] . '">' . PATH . 'personal/login/?email-confirmation=' . $this->attributes['confirm_code'] . '</a>';

                $mail->send();

                $_SESSION['success'] = 'Вы успешно зарегистрированы. <br>Для подтвержения Вашего email, 
                перейдите по ссылке в отправленном Вам письме.';
                unset($_SESSION['form_data']);
                redirect('/');
            } else {
                $_SESSION['error'] = 'Ошибка! Попробуйте позже';
            }
        }

        if (isset($_GET['auth'])) {
            if (($_GET['auth'] == 'vk'))
                $this->regVk();
        }
    }


    public function loginAction()
    {
        if (isset($_GET['email-confirmation'])) {
            $code = trim($_GET['email-confirmation']);
            if (empty($code)) {
                $_SESSION['error'] = "Не удалось подтвердить Ваш email, возможно код уже устарел";
                redirect("/");
            }
            $personal = new Personal();
            $user = $personal->getUser(array(
                'confirm_code' => $code
            ));

            if ($user) {
                $cat = \R::load('users', $user->id);
                $cat->email_confirm = 1;
                $cat->confirm_code = "";
                \R::store($cat);
                $_SESSION['success'] = "Ваш email подтвержден";
                redirect("/");
            } else {
                $_SESSION['error'] = "Не удалось подтвердить Ваш email, возможно код уже устарел";
                redirect("/");
            }
        }
        if (!empty($_POST)) {
            if (!isset($_SESSION['auth']['count'])) {
                $_SESSION['auth']['count'] = 0;
            }
            $personal = new Personal();
            $data = $_POST;
            $this->load($data);
            if ($_SESSION['auth']['count'] > 5) {
                if (!$this->checkRecaptcha($data['g-recaptcha-response'], '6Ld0mHYUAAAAAExbFPKrc8tzUen2EXBeOMQW8HKt')) {
                    $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">Капча не пройдена</p>';
                    redirect();
                }
            }

            if ($this->attributes['email'] and $this->attributes['password']) {
                $user = $personal->getUser(array(
                    'email' => $this->attributes['email']
                ));
                if ($user) {
                    if (password_verify($this->attributes['password'], $user->password)) {
                        $remember = array();
                        if (isset($data['remember'])) {
                            $remember = array('user_id' => $user->id);
                        }
                        $this->attributes['user_id'] = $user->id;
                        $this->setSession($user->id, $remember);
                        $_SESSION['success'] = 'Вы успешно авторизованы';
                        unset($_SESSION['auth']);
                        unset($_SESSION['form_data']);
                        redirect('/');
                    }
                }
            }

            $_SESSION['auth']['count']++;
            $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">E-mail/пароль введены неверно</p>';
            //$_SESSION['error'] = 'E-mail/пароль введены неверно';

            redirect();
        }

        if (isset($_GET['auth'])) {
            if (($_GET['auth'] == 'vk'))
                $this->authVk();
        }

        $this->setTitle('Workout :: Вход');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('login');
            $data = array(
                'data' => array(
                    'type' => 'login',
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        }
    }

    public function logoutAction()
    {
        $this->resetSession();
        redirect('/');
    }

    public function resetAction()
    {
        $this->setTitle('Workout :: Восстановление пароля');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        $may_reset = false;

        if (isset($_GET['reset_key'])) {
            $token = $_GET['reset_key'];
            $personal = new Personal();
            $order = $personal->getUser(array(
                'token' => $token
            ), 'password_resets');

            if ($order) {
                $d1 = strtotime($order->created_at); // переводит из строки в дату
                if (time() - $d1 >= 3600 * 72) {
                    $may_reset = false;
                    $_SESSION['auth']['count']++;
                    unset($_SESSION['reset']);
                    $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">Устаревший или недействительный код</p>';
                } else {
                    $may_reset = true;
                    $_SESSION['reset']['email'] = $order->email;
                }
            } else {
                unset($_SESSION['reset']);
                $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">Устаревший или недействительный код</p>';
            }
        }

        if (!empty($_POST)) {
            $this->attributes = [
                'password' => '',
                'password_repeat' => '',
            ];
            $this->rules = [
                'required' => [
                    ['password'],
                    ['password_repeat'],
                ],
                'not_different' => [
                    ['password', 'password_repeat'],
                ],
                'lengthMin' => [
                    ['password', 6],
                ],
            ];
            if (!isset($_SESSION['auth']['count'])) {
                $_SESSION['auth']['count'] = 0;
            }
            $personal = new Personal();
            $data = $_POST;
            $this->load($data);
            if ($_SESSION['auth']['count'] > 5) {
                if (!$this->checkRecaptcha($data['g-recaptcha-response'], '6Ld0mHYUAAAAAExbFPKrc8tzUen2EXBeOMQW8HKt')) {
                    $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">Капча не пройдена</p>';
                    redirect();
                }
            }

            if (!$this->validate($data)) {
                if (isset($personal->errors['errors'])) $this->errors = $personal->errors['errors'];
                $this->setErrors($this->errors);
                $_SESSION['form_data'] = $data;
                $this->setErrorsTest($this->errors);
                /*$_SESSION['form_data']['errors'] = $this->errors;*/
                redirect();
            }

            $this->attributes['password'] = password_hash($this->attributes['password'], PASSWORD_DEFAULT);

            $restoration_record = $personal->getUser(array($_SESSION['reset']['email']), 'password_resets');
            if ($restoration_record)
            {
                \R::trash($restoration_record);
            }

            $password_resets = \R::load('users', $personal->getUser(array('email' => $_SESSION['reset']['email']), 'users'));
            $password_resets->password = $this->attributes['password'];

            unset($this->attributes['password_repeat']);

            if (\R::store($password_resets)) {
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                //Recipients
                $mail->setFrom(SITE_EMAIL, SITE_NAME);
                $mail->addAddress($this->attributes['email']);     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Изменение пароля';
                $mail->Body = 'Уважаемый пользователь! <br>
                    Ваш пароль был только что изменен, если Вы этого не делали, напишите нам.';

                $mail->send();

                $_SESSION['success'] = 'Пароль успешно изменен.';
                unset($_SESSION['auth']);
                unset($_SESSION['form_data']);
                unset($_SESSION['reset']);
                redirect('/');
            } else {
                unset($_SESSION['reset']);
                $_SESSION['error'] = 'Ошибка! Попробуйте позже';
            }
        }

        if (!$may_reset) {
            unset($_SESSION['reset']);
            redirect('/personal/restoration');
        }

    }

    public function restorationAction()
    {
        $this->setMeta('Восстановление пароля');
        if (!empty($_POST)) {
            $personal = new Personal();
            $data = $_POST;
            $this->load($data);

            if ($this->attributes['email']) {

                $user = $personal->getUser(array(
                    'email' => $this->attributes['email']
                ));
                $this->attributes['token'] = md5($this->attributes['email'] . generateSalt());
                $this->attributes['created_at'] = date("Y-m-d H:i:s");
                if ($password_resets = $personal->getUser(array('email' => $this->attributes['email']), 'password_resets')) {
                    $password_resets = \R::load('password_resets', $password_resets->id);
                    $password_resets->token = $this->attributes['token'];
                    $password_resets->created_at = $this->attributes['created_at'];
                    $bool = \R::store($password_resets);
                } else {
                    $bool = $personal->save('password_resets', $this->attributes);
                }

                if ($user and $bool) {
                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";
                    //Recipients
                    $mail->setFrom(SITE_EMAIL, SITE_NAME);

                    $mail->addAddress($this->attributes['email']);     // Add a recipient
                    $date = date("d.m.Y", time() + 3600 * 72);;
                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Восстановление пароля WorkoutDiary';
                    $mail->Body = 'Уважаемый пользователь!<br>
                    Что бы восстановить свой пароль, перейдите по ссылке ниже: <br/>
                    <a href="' . PATH . 'personal/reset/?reset_key=' . $this->attributes['token'] . '">' . PATH . 'personal/reset/?reset_key=' . $this->attributes['token'] . '</a>' . '<br>' .
                        'Ссылка действительна до  ' . $date . '<br>' .
                        'Если вы не запрашивали восстановление пароля, проигнорируйте это письмо.';

                    $mail->send();

                    $_SESSION['success'] = 'На ' . $this->attributes['email'] . ' отправлено письмо с инструкцией для сброса пароля';
                    unset($_SESSION['auth']);
                    redirect();
                }
            }
            $_SESSION['form_data']['errors']['not_found'] = '<p class="red-text">Пользователь с таким email не найден</p>';
        }
    }

    public function setErrorsTest($err)
    {
        foreach ($err as $key => $error) {
            $errors = '<ul class="red-text">';
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
            $errors .= '</ul>';
            $_SESSION['form_data']['errors'][$key] = $errors;
        }

    }

    public function setErrors($err)
    {
        $errors = '<ul>';
        foreach ($err as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        //$_SESSION['error'] = $errors;
    }

    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = clear($data[$name]);
            }
        }
    }

    public function validate($data)
    {
        Validator::addRule('not_different', function ($field, $value, array $params, array $fields) {
            if (isset($params[0]) and isset($value)) {
                if (trim($fields[$params[0]]) == trim($value)) {
                    return true;
                }
            }
            return false;
        }, 'не совпадает с проверкой');

        Validator::langDir(WWW . '/valitron/lang');
        Validator::lang('ru');
        $v = new Validator($data);

        $v->rules($this->rules);
        $v->labels($this->labels);
        if (!$v->validate()) {
            $this->errors = $v->errors();
        }

        if (!$this->checkRecaptcha($data['g-recaptcha-response'], '6Ld0mHYUAAAAAExbFPKrc8tzUen2EXBeOMQW8HKt')) {
            $this->errors['recaptcha'] = array(
                'Не пройдена капча',
            );
        }

        if (!empty($this->errors)) {
            return false;
        }

        return true;
    }

    private function initVk($redirect)
    {
        $vk = new VKAuth(array(
            "client_id" => 6728305,
            "client_secret" => 'uAeKrvtdoY2qMxv7LnFQ',
            "redirect_uri" => $redirect,
            "v" => "5.85"
        ));

        return $vk;
    }

    public function authVk($vk = false)
    {
        if ($vk) {
            $personal = new Personal();
            $data = $vk->user_info;
            $user_vk = $personal->getUser(array(
                'vk_id' => $data['id']
            ));
            if ($user_vk and $user_vk->vk_auth == 1) {
                $this->attributes['user_id'] = $user_vk->id;
                $this->setSession($user_vk->id);
                $_SESSION['success'] = 'Вы успешно авторизованы';
                redirect('/');
            } else {
                $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Мы не нашли Ваш аккаунт, возможно Вы не зарегистрированы. Перейдите на страницу регистрации</p>';
            }
        } else {
            $vk = $this->initVk(PATH . 'personal/login?auth=vk');
            $vk->get_link();
            if (isset($_GET["error"])) {
                debug($_GET["error"]);
            }
            if (isset($_GET["code"])) {
                if ($vk->auth($_GET["code"])) {
                    // Делаем свои дела
                    $personal = new Personal();
                    $data = $vk->user_info;
                    $user_vk = $personal->getUser(array(
                        'vk_id' => $data['id']
                    ));
                    if ($user_vk and $user_vk->vk_auth == 1) {
                        $this->attributes['user_id'] = $user_vk->id;
                        $this->setSession($user_vk->id);
                        $_SESSION['success'] = 'Вы успешно авторизованы';
                        redirect('/');
                    } else {

                        //exit();
                        $this->regVk($vk);
                        //$_SESSION['form_data']['errors']['social'] = '<p class="red-text">Мы не нашли Ваш аккаунт, возможно Вы не зарегистрированы. Перейдите на страницу регистрации</p>';
                    }
                }
            }
            if (!isset($_GET["code"])) {
                redirect($vk->get_link());
            }
        }
    }

    public function regVk($vk = false)
    {
        if ($vk) {
            $personal = new Personal();

            if (!$personal->checkUnique(['vk_id' => $vk->user_info['id']])) {
                $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Кажется, Вы уже зарегистрированы. Перейдите на страницу авторизации</p>';
                redirect('/personal/reg');
            } else {
                $link = $vk->user_info['photo_medium'];
                $data['avatar'] = LoadAndResize($link, WWW . '/uploads/images/users/');
                $user_info = $vk->user_info;
                $data['name'] = $user_info['first_name'];
                $data['surname'] = $user_info['last_name'];
                $data['birthday'] = date("Y.m.d", strtotime($user_info['bdate']));
                $data['vk_id'] = $user_info['id'];
                $data['vk_auth'] = 1;
                $this->load($data);
                unset($this->attributes['password_repeat']);
                if ($personal->save('users', $this->attributes)) {
                    $user_vk = $personal->getUser(array(
                        'vk_id' => $data['vk_id']
                    ));
                    if ($user_vk) {
                        $this->attributes['user_id'] = $user_vk->id;
                        $this->setSession($user_vk->id);
                        $_SESSION['success'] = 'Вы успешно зарегистрированы';
                        redirect('/');
                    } else {
                        $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Ошибка! Попробуйте позже</p>';
                    }
                } else {
                    $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Ошибка! Попробуйте позже</p>';
                }
            }
        } else {
            $vk = $this->initVk(PATH . 'personal/reg?auth=vk');

            $vk->get_link();
            if (isset($_GET["error"])) {
                debug($_GET["error"]);
            }
            if (isset($_GET["code"])) {
                if ($vk->auth($_GET["code"])) {
                    // Делаем свои дела
                    $personal = new Personal();

                    if (!$personal->checkUnique(['vk_id' => $vk->user_info['id']])) {
                        $this->authVk($vk);
                        //$_SESSION['form_data']['errors']['social'] = '<p class="red-text">Кажется, Вы уже зарегистрированы. Перейдите на страницу авторизации</p>';
                        //redirect('/personal/reg');
                    } else {
                        $link = $vk->user_info['photo_medium'];
                        $data['avatar'] = LoadAndResize($link, WWW . '/uploads/images/');
                        $user_info = $vk->user_info;
                        $data['name'] = $user_info['first_name'];
                        $data['surname'] = $user_info['last_name'];
                        $data['birthday'] = date("Y.m.d", strtotime($user_info['bdate']));
                        $data['vk_id'] = $user_info['id'];
                        $data['vk_auth'] = 1;
                        $this->load($data);
                        unset($this->attributes['password_repeat']);
                        if ($personal->save('users', $this->attributes)) {
                            $user_vk = $personal->getUser(array(
                                'vk_id' => $data['vk_id']
                            ));
                            if ($user_vk) {
                                $this->attributes['user_id'] = $user_vk->id;
                                $this->setSession($user_vk->id);
                                $_SESSION['success'] = 'Вы успешно зарегистрированы';
                                redirect('/');
                            } else {
                                $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Ошибка! Попробуйте позже</p>';
                            }
                        } else {
                            $_SESSION['form_data']['errors']['social'] = '<p class="red-text">Ошибка! Попробуйте позже</p>';
                        }
                    }
                }
            }
        }
        if (!isset($_GET["code"])) {
            redirect($vk->get_link());
        }
    }
}