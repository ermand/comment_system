<?php namespace App;

use DateTime;

class Post {

    private $id;
    private $name;
    private $email;
    private $message;
    private $created_at;

    protected $errors = [];
    private $hasError = false;

    private $rules = [
        'name' => 'minLength[3]',
        'email' => 'minLength[4]|maxLength[64]',
        'message' => 'minLength[10]'
    ];

    public function __construct($postData = []){
        if ( ! empty($postData))
        {
            $this->create($postData);
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function create(array $postData)
    {
        foreach ($postData as $field => $value)
        {
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

            $this->setProperty($value, $field);
            $this->created_at = new DateTime();
        }

        return $this;
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
