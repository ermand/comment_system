<?php
use App\Controllers\CommentsController;
use App\Controllers\PostsController;

// Get current URL separated by parameters.
$currentUrl = explode("?", $_SERVER['REQUEST_URI']);
$uri = $currentUrl[0] ;

// Get requested method.
$requestMethod = $_SERVER['REQUEST_METHOD'];

/**
 * Route cases.
 */
if ($uri === '/index.php' || $uri === '/' )
{
    PostsController::getIndex();
}
elseif (strpos($uri, '/create') !== FALSE && $requestMethod === 'GET')
{
    PostsController::getCreate();
}
elseif ($uri === '/create' && $requestMethod === 'POST' )
{
    PostsController::postStore();
}
elseif ( strpos($uri, '/show') !== FALSE && isset($_GET['id']))
{
    PostsController::getShow($_GET['id']);
}
elseif (strpos($uri, '/comments') !== FALSE && isset($_GET['id']))
{
    PostsController::getComments($_GET['id']);
}
elseif ($uri === '/comments/store' && $requestMethod === 'POST')
{
    CommentsController::postStore();
}
else
{
    header('Status: 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}
