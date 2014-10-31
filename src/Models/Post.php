<?php namespace App\Models;

use App\Repository\PostRepository;
use App\Validator;
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

    public function __construct(PostRepository $postRepository = null)
    {
        $this->postRepository = ($postRepository === null) ? new PostRepository() : $postRepository;
    }

    public function init(array $postData)
    {
        foreach ($postData as $field => $value)
        {
//            $data = [
//                'field' => $field,
//                'value' => $value
//            ];
//
//            $validator = new Validator();
//            $validator->validate($data, $this->rules);
//            if ($validator->fails)
//            {
//                $this->hasError = true;
//                $this->errors[] = $validator->errors;
//            }

            $this->setProperty($value, $field);
            $this->created_at = new DateTime();
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasError()
    {
        return $this->hasError;
    }

    /**
     * @param boolean $hasError
     */
    public function setHasError($hasError)
    {
        $this->hasError = $hasError;
    }

    public function create(array $postData)
    {
        $post = $this->init($postData);

        $post = $this->postRepository->save($post);


        return $post;

//        $sql = "INSERT INTO " . self::$tableName . " (";
//        $sql .= join(", ", array_keys($postData));
//        $sql .= ") VALUES ('";
//        $sql .= join("', '", array_values($postData));
//        $sql .= "')";
//
//        $database->query($sql);
//        $database->execute();
//        echo $database->lastInsertId();

//        foreach ($postData as $field => $value)
//        {
//            $data = [
//                'field' => $field,
//                'value' => $value
//            ];
//
//            $validator = new Validator();
//            $validator->validate($data, $this->rules);
//            if ($validator->fails)
//            {
//                $this->hasError = true;
//                $this->errors[] = $validator->errors;
//            }
//
//            $this->setProperty($value, $field);
//            $this->created_at = new DateTime();
//        }
//
//        return $this;
    }

    public static function all()
    {
        $post = new self;

        return $post->postRepository->findAll();
    }

    public static function find($id)
    {
        $post = new self;

        return $post->postRepository->find($id);
    }

    public static function whereName($name)
    {
        $post = new self;

        return $post->postRepository->findByColumn('name', $name);
    }

    public static function whereEmail($name)
    {
        $post = new self;

        return $post->postRepository->findByColumn('name', $name);
    }

    public static function where($column, $value, $operator = '=')
    {
        $post = new self;

        return $post->postRepository->findByColumn($column, $value, $operator);
    }

    public function update()
    {
        return $this->postRepository->update($this);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->id);
    }

    /**
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
