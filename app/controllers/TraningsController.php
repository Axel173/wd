<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class TraningsController extends AuthController
{

    public function indexAction()
    {

        $this->setTitle('Workout :: Тренировки');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('index');
            $data = array(
                'data' => array(
                    'type' => 'trainings',
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

}