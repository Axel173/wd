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

        if (!$this->is_auth) {
            redirect('/personal/login');
        }
        //$programs = array();
        $programs = \R::findMulti('programs, programs_list, exercises, days',
            'SELECT programs.*, programs_list.*, exercises.*, days.* FROM programs 
                INNER JOIN programs_list ON programs_list.program_id=programs.id 
                INNER JOIN exercises ON programs_list.exercise_id=exercises.id
                INNER JOIN days ON programs_list.day_id=days.id');

        /*$programs['programs'] = reset($programs_bean['programs']);
        $programs['programs_list'] = reset($programs_bean['programs_list']);
        $programs['exercises'] = reset($programs_bean['exercises']);
        $programs['days'] = reset($programs_bean['days']);*/

        /*foreach ($programs['programs'] as $key => $item)
        {

        }*/

        $this->set(compact('programs'));

        $this->setTitle('Workout :: Программы тренировок');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');


    }

}