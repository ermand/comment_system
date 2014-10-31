<?php
require 'vendor/autoload.php';
include(controllersPath() . 'PostController.php');

// route the request internally
$uri = $_SERVER['REQUEST_URI'];
//var_dump($uri);

if ($uri === '/index.php' || $uri === '/' )
{
    posts_index();
}
elseif ($uri === '/create')
{
    posts_create();
}
elseif ( strpos($uri, '/show') !== FALSE && isset($_GET['id']))
{
    posts_show($_GET['id']);
}
else
{
    header('Status: 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}



// Page Content
//includeView('Posts/create');
// End Page Content
