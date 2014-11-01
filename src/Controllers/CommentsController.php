<?php namespace App\Controllers;

use App\Models\Comment;

class CommentsController {

    /**
     * Store comment to database.
     *
     * @throws InvalidArgumentException
     */
    public static function postStore()
    {
        if ( checkSpammer() )
        {
            $error = ['spam' => true, 'message' => 'Sorry spammer! You are not allowed to leave coments.'];
            echo json_encode($error);
            exit;
        }

        $message = '';
        $messageType = 'danger';

        /**
         * Try to create new customer with POST input data.
         */
        try {
            $postId = $_POST['post_id'];
            $commentData = [
                'post_id' => $postId,
                'name'    => $_POST['name'],
                'email'   => $_POST['email'],
                'message' => $_POST['message'],
            ];
            $newComment = new Comment();
            $newComment->create($commentData);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        /**
         * If during customer create has been as error, such as validation, assign them to $message.
         */
        if ($newComment->hasError())
        {
            foreach ($newComment->getErrors() as $error)
            {
                $message .= " - " . $error . "<br>";
            }
        }
        else
        {
            $_SESSION['messageType'] = 'error';
            $_SESSION['message'] = $message;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            echo json_encode($newComment);
        }
        else
        {
            $_SESSION['messageType'] = 'success';
            $_SESSION['message'] = 'Comment was successfully created.';
            header('Location: /show?id='. $postId);
        }

    }
}


