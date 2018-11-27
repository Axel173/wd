<?php

namespace app\controllers;

use app\models\Main;
use fw\libs\Pagination;

/**
 * Description of Main
 *
 */
class ExercisesController extends AppController
{
    private $cache_time = 1;

    public function indexAction()
    {
        $alias = '';
        $group_id = 0;

        $this->setTitle('Workout :: Упражнения');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if (!$this->is_auth) {
            redirect('/personal/login');
        }

        if (isset($this->route['alias'])) {
            $alias = clear($this->route['alias']);

            $group = \R::findOne('groups',
                ' alias = ? ', array($alias));
            $group_id = $group->id;
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 8;


        if ($group_id) {
            $total = \R::count('exercises', 'group_id = ?', [$group_id]);
            $pagination = new Pagination($page, $perpage, $total);
            $start = $pagination->getStart();
            $exercises = \R::findAll('exercises', "group_id = ? LIMIT $start, $perpage", [$group_id]);
        } else {
            $total = \R::count('exercises');
            $pagination = new Pagination($page, $perpage, $total);
            $start = $pagination->getStart();
            $exercises = \R::findAll('exercises', "LIMIT $start, $perpage");
        }

        if ($this->isAjax()) {
            $template = $this->getTmp('index', compact('exercises', 'pagination', 'total'));
            $data = array(
                'data' => array(
                    'type' => 'exercises',
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        } else {
            $this->set(compact('exercises', 'pagination', 'total'));
        }





    }

    /*public function viewAction()
    {
        $alias = clear($this->route['alias']);
        $exercise = \R::findOne('exercises',
            ' alias = ? ', array($alias));

        $this->setTitle('Workout :: Упражнение ' . $exercise['name']);
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        $this->set(compact('exercise'));
    }*/

    public function testAction()
    {
        if ($this->isAjax()) {
            $model = new Main();
            $post = \R::findOne('posts', "id = {$_POST['id']}");
            $this->loadView('_test', compact('post'));
            die;
        }
        echo 222;
    }
}