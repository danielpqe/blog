<?php
//FRONT CONTROLLER(PATRON DE DISEÑO):
//ES UN CONTROLADOR QUE RECIBE TODAS LAS PETICIONES, Y SE HACE CARGO DEL FLUJO
//QUE ES COMUN A NUESTRA APLICACION
//init_set('display_errors',1);//Inicializar valores de config
//init_set('displa_startup_errors',1);
//error_reporting(E_ALL);

require_once '../vendor/autoload.php';
include_once '../config.php';

$baseUrl='';
$baseDir=str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
$baseUrl='http://'.$_SERVER['HTTP_HOST'].'/IntroduccionPHP/blog/view/';
//var_dump($baseUrl);
define('BASE_URL',$baseUrl);

$dotenv= new \Dotenv\Dotenv(__DIR__.'/..');
$dotenv->load();
$capsule = new Capsule;
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$route=$_GET['route'] ?? '/'; //Si no existe, nos vamos a la base de la app


use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();
$router->get('/admin',function () {
return render('../view/admin/index.twig');
});
$router->get('admin/posts',function () use($pdo){

//include_once '../config.php';
$query=$pdo->prepare('select * from blog_post order by id desc');
$query->execute();

$blogPost=$query->fetchAll(PDO::FETCH_ASSOC);

    return render('../view/admin/post.twig',['blogpost'=>$blogPost]);
});

$router->get('/',function () use ($pdo) {
    $query=$pdo->prepare('select * from blog_post order by id desc');
    $query->execute();
    $blogPost=$query->fetchAll(PDO::FETCH_ASSOC);
    return render('../view/index.twig',['blogPost'=>$blogPost]);
//    include '../view/index.twig';
});

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);
echo $response;

//ejemplo sin route
//switch ($route){
//    case '/':require '../index.twig';break;
//    case '/admin':require '../admin/index.twig';break;
//    case '/admin/post':require '../admin/post.twig';
//}