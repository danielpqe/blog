<?php
namespace App\Controllers;
use Twig_Loader_Filesystem;
class BaseController{
    protected $templateEngine;
    public function __construct()
    {$loader= new Twig_Loader_Filesystem('../view');
    $this->templateEngine= new \Twig_Environment([
        'debug0'=>true,
        'cache'=>false
    ]);
        $this->templateEngine->addFilter(\Twig_SimpleFilter('url',function ($path){
            return BASE_URL.$path;
        }));//Filtro url, agregar como prefijo
    }

    public function render($fileName,$data=[]){
    return $this->templateEngine->render($fileName,$data);

    }
}