<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class ProgramsController extends AppController
{

    public function indexAction()
    {

        $this->setTitle('Workout :: Программы тренировок');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');
        if (!$this->is_auth) {
            redirect('/personal/login');
        }
    }

}