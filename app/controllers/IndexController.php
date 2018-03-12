<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\BlogPost;

class IndexController extends BaseController {
public function getIndex(){
//    global $pdo;
//
//    $query=$pdo->prepare('select * from blog_post order by id desc');
//    $query->execute();
//
//$blogPosts=$query->fetchAll(\PDO::FETCH_ASSOC);
    $blogPosts=BlogPost::query()->orderBy('id','desc')->get();
return $this->render('index.twig',['blogPosts'=>$blogPosts]);
}
}