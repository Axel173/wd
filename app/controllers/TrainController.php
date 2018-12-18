<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class TrainController extends AuthController
{

    public function indexAction()
    {
        $this->setTitle('Workout :: Программы тренировок');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('index');
            $data = array(
                'data' => array(
                    'type' => 'train',
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