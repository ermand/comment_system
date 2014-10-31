<?php

require 'vendor/autoload.php';

//$post = new \App\Post();
//var_dump($post->show(12));
$post = new \App\Models\Post();

//var_dump($post);

/**
 * Create
 */
//$userData = [
//    'name'    => 'Ermand Durro',
//    'email'   => 'email@gmail.com',
//    'title' => 'First Post',
//    'message' => 'My very first test Post'
//];
//$newPost = $post->create($userData);
//var_dump($newPost);

/**
 * Show all
 */
$allPosts = \App\Models\Post::all();
var_dump($allPosts);

echo "<hr>";

/**
 * Find
 */
//$showPost = \App\Models\Post::find(11);
//var_dump($showPost);

/**
 * Find by name
 */
$posts = \App\Models\Post::whereName('Ermand Duro');
if ($posts)
{
    foreach ($posts as $post)
    {
        var_dump($post->id);
    }
}
else
{
    var_dump('No Post exists by this name');
}

/**
 * Find by column
 */
$posts = \App\Models\Post::where('email', 'test%', 'like');
if ($posts)
{
    foreach ($posts as $post)
    {
        var_dump($post->id);
    }
}
else
{
    var_dump('No Post exists by this name');
}

//var_dump($showPost);

/**
 * Update
 */
//$showPost->name = 'Ermand Durro';
//$showPost->update();

//$showPost = $updatePost->show(1);
//var_dump($showPost);

//echo "<pre>";
//var_dump($post);
//exit;