<?php namespace App\Models;

use App\Repository\CommentRepository;
use DateTime;

class Comment {

    public $name;
    public $email;
    public $message;
    public $created_at;

    protected $errors = [];
    private $hasError = false;
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository = null)
    {
        $this->commentRepository = ($commentRepository === null) ? new CommentRepository() : $commentRepository;
    }

    /**
     * Initialize comment object.
     *
     * @param array $commentData
     * @return $this
     */
    public function init(array $commentData)
    {
        foreach ($commentData as $field => $value)
        {
            $this->setProperty($value, $field);
            $this->created_at = new DateTime();
        }

        return $this;
    }

    /**
     * Return has error parameter.
     *
     * @return boolean
     */
    public function isHasError()
    {
        return $this->hasError;
    }

    /**
     * Set has error.
     *
     * @param boolean $hasError
     */
    public function setHasError($hasError)
    {
        $this->hasError = $hasError;
    }

    /**
     * Create new comment.
     *
     * @param array $commentData
     * @return Comment|bool
     */
    public function create(array $commentData)
    {
        $comment = $this->init($commentData);

        $comment = $this->commentRepository->save($comment);

        return $comment;
    }

    /**
     * Get all comments.
     *
     * @return array
     */
    public static function all()
    {
        $comment = new self;

        return $comment->commentRepository->findAll();
    }

    /**
     * Find comment by id.
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        $comment = new self;

        return $comment->commentRepository->find($id);
    }

    /**
     * Find comment based on name.
     *
     * @param $name
     * @return array
     */
    public static function whereName($name)
    {
        $comment = new self;

        return $comment->commentRepository->findByColumn('name', $name);
    }

    /**
     * Find comment based on email.
     *
     * @param $name
     * @return array
     */
    public static function whereEmail($name)
    {
        $comment = new self;

        return $comment->commentRepository->findByColumn('name', $name);
    }

    /**
     * Find comment based on column, value and operator.
     *
     * @param $column
     * @param $value
     * @param null $operator
     * @param null $orderByColumn
     * @param null $orderBy
     * @return array
     */
    public static function where($column, $value, $operator = NULL, $orderByColumn = NULL, $orderBy = NULL)
    {
        $comment = new self;

        return $comment->commentRepository->findByColumn($column, $value, $operator, $orderByColumn, $orderBy);
    }

    /**
     * Set object property.
     *
     * @param $value
     * @param $field
     * @return mixed
     */
    private function setProperty($value, $field)
    {
        return $this->{$field} = $value;
    }

    /**
     * Check if there are any errors.
     *
     * @return boolean
     */
    public function hasError()
    {
        return $this->hasError;
    }

    /**
     * Get Errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

} 