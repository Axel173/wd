<?php

namespace app\controllers;

use app\models\Main;
use fw\App;
use fw\base\View;

/**
 * Description of Main
 *
 */


class MainController extends AuthController{

    public function indexAction(){
        //$model = new Main;

        /*$lang = App::$app->getProperty('lang')['code'];
        $total = \R::count('posts', 'lang_code = ?', [$lang]);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 2;

        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $posts = \R::findAll('posts', "lang_code = ? LIMIT $start, $perpage", [$lang]);
        View::setMeta('Blog :: Главная страница', 'Описание страницы', 'Ключевые слова');
        $this->set(compact('title', 'posts', 'pagination', 'total'));*/

        //$this->setMeta('Workout :: Главная страница', 'Описание страницы', 'Ключевые слова');
        $this->setTitle('Workout :: Главная страница');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('index');
            $data = array(
                'data' => array(
                    'type' => 'main',
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        }
        //mail("alex310197@mail.ru", "My Subject", "Line 1\nLine 2\nLine 3");
    }
    
    public function testAction(){
        if($this->isAjax()){
            $model = new Main();
            $post = \R::findOne('posts', "id = {$_POST['id']}");
            $this->loadView('_test', compact('post'));
            die;
        }
        echo 222;
    }
}