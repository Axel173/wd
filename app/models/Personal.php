<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 20.10.2018
 * Time: 21:36
 */

namespace app\models;


use fw\base\Model;

class Personal extends Model
{
    public $errors;

    public function checkUnique($data)
    {
        $arr = $this->test($data, 'OR');
        $user = \R::findOne('users', $arr['param'] . ' LIMIT 1', $arr['arr_value']);

        if ($user) {
            foreach ($data as $key => $value) {
                if ($user->$key == $value) {
                    //$this->errors['unique'][] = $value . ' уже существует';
                    $this->errors['errors'][$key][] = $value . ' уже существует';
                }
            }
            return false;
        }
        return true;
    }

    public function setUser()
    {

    }

    public function getUser($data, $tbl = 'users')
    {
        $arr = $this->test($data, 'AND');

        $user = \R::findOne($tbl, $arr['param'] . ' LIMIT 1', $arr['arr_value']);

        if ($user) {
            return $user;
        }
        return false;
    }

    public function test($data, $condition)
    {
        $param = '';
        $concat = '';
        $arr_value = array();
        $iter = 0;
        foreach ($data as $key => $value) {
            if ($iter > 0) {
                $concat = $condition . ' ';
            }
            $param .= $concat . $key . ' = ? ';
            $arr_value[] = $value;
            $iter++;
        }

        return array('param' => $param, 'arr_value' => $arr_value);
    }

    public function login($data = array())
    {

    }
}