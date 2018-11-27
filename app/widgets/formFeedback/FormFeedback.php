<?php

namespace app\widgets\formFeedback;

use fw\App;

class FormFeedback{

    protected $tpl = '';
    protected $attributes = [
        'name' => '',
        'email' => '',
    ];

    protected $rules = array(
        'required' => array(
            array('name'),
            array('email'),
        ),
        'email' => array(
            array('email'),
        ),
    );

    protected $labels = array(
        'name' => 'Поле',
        'email' => 'Поле',
    );
    protected $message = '';
    protected $action = '/';
    protected $method = 'POST';
    protected $errors = array();
    protected $html = '';
    protected $fields = array(
        array(
            'name' => 'email',
            'type' => 'email',
            'class' => 'validate',
            'id' => 'validate',
            'placeholder' => '',
            'required' => '',
            'label' => true,
            'label_name' => '',
            'label_class' => '',
        )
    );

    public function __construct($options = array()){
        $this->tpl = __DIR__ . '/formFeedback/default.php';
        $this->getOptions($options);
        $this->run();
    }

    protected function getOptions($options){
        if($options)
        {
            foreach($options as $k => $v)
            {
                if(!empty($v))
                {
                    if(property_exists($this, $k))
                    {
                        $this->$k = $v;
                    }
                }

            }
        }
    }

    protected function output(){
        echo $this->html;
    }

    protected function run(){
        $this->html = $this->template();
        $this->output();
        /*$cache = new Cache();
        $this->menuHtml = $cache->get($this->cacheKey);
        if(!$this->menuHtml){
            $this->data = \R::getAssoc("SELECT * FROM {$this->table}");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
        }
        $this->output();*/
    }

    protected function getTree(){
        $tree = [];
        $data = $this->data;
        foreach ($data as $id=>&$node) {
            if (!$node['parent']){
                $tree[$id] = &$node;
            }else{
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''){
        $str = '';
        foreach($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id, count($tree));
        }
        return $str;
    }

    protected function template(){
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

}