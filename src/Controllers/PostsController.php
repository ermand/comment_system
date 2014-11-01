<?php namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;

class PostsController {

    /**
     * Get all posts
     */
    public static function getIndex()
    {
        $posts = Post::all();
        require 'src/Views/Posts/list.php';
    }

    /**
     * @param $id
     */
    public static function getShow($id)
    {
        $post = Post::find($id);

        $comments = Comment::where('post_id', $post->id);
        $has_comments = (count($comments) > 0);

        require 'src/Views/Posts/show.php';
    }

    /**
     * Include post create form.
     */
    public static function getCreate()
    {
        require 'src/Views/Posts/create.php';
    }

    /**
     * Get comments per post.
     *
     * @param $id
     */
    public static function getComments($id)
    {
        $comments = Comment::where('post_id', $id, NULL, NULL, NULL);
        $has_comments = (count($comments) > 0);

        echo json_encode($comments);
    }

    /**
     * Store post to database.
     * @throws InvalidArgumentException
     */
    public static function postStore()
    {
        checkSpammer();

        $message = '';
        $messageType = 'danger';

        /**
         * Try to create new post with POST input data.
         */
        try {
            $postData = [
                'name'    => $_POST['name'],
                'email'   => $_POST['email'],
                'title'   => $_POST['title'],
                'message' => $_POST['message'],
            ];
            $newPost = new Post();
            $newPost->create($postData);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        /**
         * If during customer create has been as error, such as validation, assign them to $message.
         */
        if ($newPost->hasError())
        {
            foreach ($newPost->getErrors() as $error)
            {
                $message .= " - " . $error . "<br>";
            }

            $_SESSION['messageType'] = 'error';
            $_SESSION['message'] = $message;

            header('Location: /create?status=fail');
        }
        else
        {
            $_SESSION['messageType'] = 'success';
            $_SESSION['message'] = 'Post was successfully created.';
            header('Location: /');
        }

        exit;
    }

}


