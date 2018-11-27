<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class ExerciseController extends AppController
{
    public function viewAction()
    {
        if (!$this->is_auth) {
            redirect('/personal/login');
        }
        $alias = clear($this->route['alias']);

        $exercises = \R::findMulti('exercises, groups', 'SELECT exercises.*, groups.*, groups.alias AS group_alias FROM groups
                INNER JOIN exercises ON exercises.group_id = groups.id
                WHERE exercises.alias = ? LIMIT 1', array($alias));

        $exercise = reset($exercises['exercises']);
        $groups = reset($exercises['groups']);

        if ($exercises) {
            $this->route['alias'] = $groups->alias;
        }

        $this->setTitle('Workout :: Упражнение ' . strtolower($exercise['name']));
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');


        if ($this->isAjax()) {
            $template = $this->getTmp('view', compact('exercise'));
            $data = array(
                'data' => array(
                    'type' => 'exercise',
                    'id' => $exercise->id,
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        } else {
            $this->set(compact('exercise'));
        }
    }
}