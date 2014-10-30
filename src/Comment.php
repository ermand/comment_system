<?php namespace App;

class Comment {

    private $id;
    private $post_id;
    private $name;
    private $email;
    private $body;
    private $errors = [];
    private $hasError = false;

    private $rules = [
        'name' => 'minLength[3]',
        'email' => 'minLength[4]|maxLength[64]',
        'body' => 'minLength[10]'
    ];

    public function create(array $commentData)
    {
        foreach ($commentData as $field => $value)
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
        }

        var_dump($this);
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
     * @return boolean
     */
    public function hasError()
    {
        return $this->hasError;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
