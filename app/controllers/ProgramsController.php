<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class ProgramsController extends AuthController
{

    public function indexAction()
    {

        $programs = array();
        $programs_bean = \R::findMulti('programs, programs_list, exercises, days, users',
            'SELECT programs.*, programs_list.*, exercises.*, days.*, users.* FROM programs 
                INNER JOIN users ON programs.user_id=users.id
                INNER JOIN programs_list ON programs_list.program_id=programs.id 
                INNER JOIN exercises ON programs_list.exercise_id=exercises.id
                INNER JOIN days ON programs_list.day_id=days.id ORDER BY programs_list.day_id, programs_list.position');
        $programs = $programs_bean['programs'];
        foreach ($programs_bean['programs'] as $program_key => $program) {
            $programs[$program_key] = object_to_array($program);
            if($program['user_id'] and $programs_bean['users'][$program['user_id']])
            {
                $programs[$program_key]['user'][$program['user_id']] = object_to_array($programs_bean['users'][$program['user_id']]);
            }
            foreach ($programs_bean['programs_list'] as $list_key => $list) {
                foreach ($programs_bean['days'] as $day_key => $day) {
                    if ($day_key == $list['day_id'] and $program['id'] == $list['program_id'] and !isset($programs[$program_key]['days'][$day_key])) {
                        $programs[$program_key]['days'][$day_key] = object_to_array($day);
                    }
                }
                if ($program['id'] == $list['program_id']) {
                    $programs[$program_key]['days'][$list['day_id']]['programs_list'][$list_key] = object_to_array($list);
                    $programs[$program_key]['days'][$list['day_id']]['programs_list'][$list_key]['exercise'] = object_to_array($programs_bean['exercises'][$list['exercise_id']]);
                }
            }
        }
        //dd($programs);
        /*$programs['programs'] = reset($programs_bean['programs']);
        $programs['programs_list'] = reset($programs_bean['programs_list']);
        $programs['exercises'] = reset($programs_bean['exercises']);
        $programs['days'] = reset($programs_bean['days']);*/
        $this->setTitle('Workout :: Программы тренировок');
        $this->setMeta('description', 'Описание страницы');
        $this->setMeta('keywords', 'Ключевые слова');

        if ($this->isAjax()) {
            $template = $this->getTmp('index', compact('programs'));
            $data = array(
                'data' => array(
                    'type' => 'programs',
                    'attributes' => array(
                        "title" => $this->title,
                        "body" => $template,
                    ),
                ),

            );
            echo json_encode($data);
            die();
        } else {
            $this->set(compact('programs'));
        }



    }

}