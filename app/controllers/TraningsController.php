<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class TraningsController extends AppController
{

    public function indexAction()
    {

        $this->setTitle('Workout :: Тренировки');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');
        if (!$this->is_auth) {
            redirect('/personal/login');
        }
    }

}