<?php

function posts_index()
{
    $posts = \App\Models\Post::all();
    require 'src/Views/Posts/list.php';
}

function posts_show($id)
{
    $post = \App\Models\Post::find($id);
    require 'src/Views/Posts/show.php';
}

function posts_create()
{
    require 'src/Views/Posts/create.php';
}

function posts_post()
{
    if (isset($_POST['submit']))
    {
        $message = '';
        $messageType = 'danger';

        /**
         * Try to create new customer with POST input data.
         */
        try {
            $postData = [
                'name'    => $_POST['name'],
                'email'   => $_POST['email'],
                'title'   => $_POST['title'],
                'message' => $_POST['message'],
            ];
            $newPost = new \App\Models\Post();
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
        }
        else
        {
            $messageType = 'success';
            $message = 'Contract was successfully created.';
        }

        header('Location: /');
    }
}

/**
 * Get current value of POST based on input name.
 *
 * @param $input
 * @return string
 */
function getCurrentValue($input)
{
    return isset($_POST[$input]) ? $_POST[$input] : '';
}

