<?php

namespace fw\base;

abstract class Controller{

    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = array();
    public $meta_string = '';
    public $title = '';

    public function __construct($route){
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    public function getView(){
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta, $this->meta_string, $this->title);
        $viewObject->render($this->data);
    }

    public function set($data){
        $this->data = $data;
    }
    public function setMetaString($meta){
        $this->meta_string .= $meta . PHP_EOL;
    }
    public function setMeta($meta = '', $content = ''){
        $this->meta[$meta] = $content;
    }
    public function setTitle($title = ''){
        $this->title = $title;
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView($view, $vars = []){
        extract($vars);
        require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        die;
    }

    public function getTmp($view, $vars = []){
        extract($vars);
        ob_start();
        {
            //$this->loadView('view', compact('exercise'));
            require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        }

        $view = ob_get_clean();
        return $view;
    }
}