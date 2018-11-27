<?php

namespace fw\base;

class View
{

    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = [];
    public $meta_string = '';
    public $title = '';

    public function __construct($route, $layout = '', $view = '', $meta = array(), $meta_string = '', $title = '')
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $view;
        $this->model = $route['controller'];
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        $this->meta_string = $meta_string;
        $this->title = $title;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }

    public function render($data)
    {
        if (is_array($data)) extract($data);
        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";
        if (is_file($viewFile)) {
            //ob_start([$this, 'compressPage']);
            //ob_start('ob_gzhandler');
            ob_start();
            {
                //header("Content-Encoding: gzip");
                require_once $viewFile;
                //$content = ob_get_contents();
            }
            //ob_clean();
            $content = ob_get_clean();
        } else {
            throw new \Exception("На найден вид {$viewFile}", 500);
        }
        if (false !== $this->layout) {
            $layoutFile = APP . "/views/layouts/{$this->layout}/index.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("На найден шаблон {$this->layout}/index.php", 500);
            }
        }
    }

    public function getMeta()
    {
        if (!empty($this->meta)) {
            foreach ($this->meta as $name => $value) {
                $this->meta_string .= '<meta name="' . $name . '" content="' . $value . '">' . PHP_EOL;
            }
            return $this->meta_string;
        }
        return false;
    }

    public function getTitle()
    {
        if (!empty(trim($this->title))) {
            return $this->title;
        }
        return false;
    }

    /*public function getMeta(){
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
        $output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }*/

}