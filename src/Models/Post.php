<?php namespace App\Models;

use App\Repository\PostRepository;
use App\Services\Validator;
use DateTime;

class Post {

    public $name;
    public $email;
    public $title;
    public $message;
    public $created_at;

    protected $errors = [];
    private $hasError = false;
    protected $postRepository;

    private static $tableName = 'posts';

    private $rules = [
        'name' => 'minLength[3]',
        'email' => 'minLength[4]|maxLength[64]',
        'message' => 'minLength[10]'
    ];

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository = null)
    {
        $this->postRepository = ($postRepository === null) ? new PostRepository() : $postRepository;
    }

    /**
     * Initialize post object.
     *
     * @param array $postData
     * @return $this
     */
    public function init(array $postData)
    {
        foreach ($postData as $field => $value)
        {
            //Validate input data based on rules.
            $data = [
                'field' => $field,
                'value' => $value
            ];

            $validator = new Validator();

            $validator->validate($data, $this->rules);
            if ($validator->fails)
            {
                $this->hasError = true;
                $this->errors[] = $validator->errors;
            }

            // Set object properties.
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
     * Create new post.
     *
     * @param array $postData
     * @return Post|array|bool
     */
    public function create(array $postData)
    {
        $post = $this->init($postData);

        // If there are errors return them.
        if ($post->hasError())
        {
            return $post->getErrors();
        }

        // Otherwise save post.
        $post = $this->postRepository->save($post);

        return $post;
    }

    /**
     * Get all posts.
     *
     * @return array
     */
    public static function all()
    {
        $post = new self;

        return $post->postRepository->findAll();
    }

    /**
     * Find post by id.
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        $post = new self;

        return $post->postRepository->find($id);
    }

    /**
     * Find post by name.
     *
     * @param $name
     * @return array
     */
    public static function whereName($name)
    {
        $post = new self;

        return $post->postRepository->findByColumn('name', $name);
    }

    /**
     * Find post by email.
     *
     * @param $name
     * @return array
     */
    public static function whereEmail($name)
    {
        $post = new self;

        return $post->postRepository->findByColumn('name', $name);
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
        $post = new self;

        return $post->postRepository->findByColumn($column, $value, $operator, $orderByColumn, $orderBy);
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
