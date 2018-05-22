<?php

class View{

    protected $data;
    protected $path;

    protected static function getDefaultPathView(){
        $router = App::getRouter();

        if(!$router){
            return false;
        }

        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.php';

        return VIEW_PATH.DS.$controller_dir.DS.$template_name;

    }

    public function __construct($data = array(), $path = null){
        if (!$path){
            $path = self::getDefaultPathView();
        }

        if(!file_exists($path)){
             //Router::redirect("/page_not_found/");
             //Router::redirect("/err/");
            throw new Exception("Template file not found ".$path);
        }

        $this->path = $path;
        $this->data = $data;
    }
    public function buffer(){
        $data = $this->data;

        ob_start();
        include($this->path);
        $html = ob_get_clean();

        return $html;
    }

    public function render($layout_path){
        $content['content_html'] = $this->data;
        include($layout_path);
    }
}
