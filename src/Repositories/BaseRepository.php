<?php namespace App\Repository;

use PDO;

abstract class BaseRepository {

    protected $connection;

    abstract protected function getTableName();
    abstract protected function getModelClass();

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        if ($this->connection === null) {
//            $this->connection = new Database();
            $this->connection = new PDO(
                'mysql:host=localhost;dbname=comment_system',
                'root',
                'secret'
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
    }

    public function find($id)
    {
        $stmt = $this->connection->prepare('
            SELECT ' . $this->getTableName() . '.*
             FROM ' . $this->getTableName() . '
             WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Set the fetchmode to populate an instance of 'User'
        // This enables us to use the following:
        //     $post = $repository->find(1234);
        //     echo $post->firstname;
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());
        return $stmt->fetch();
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM ' . $this->getTableName() . '
        ');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());

        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $users = $repository->findAll();
        //    echo $users[0]->firstname;
        return $stmt->fetchAll();
    }

    public function findByColumn($columnName, $value, $operator = '=')
    {
        $stmt = $this->connection->prepare('
            SELECT ' . $this->getTableName() . '.*
             FROM ' . $this->getTableName() . '
             WHERE ' . $columnName . ' ' . $operator . '  :column
        ');
        $stmt->bindParam(':column', $value);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());

        // fetchAll() will do the same as above, but we'll have an array. ie:
        //    $users = $repository->findAll();
        //    echo $users[0]->firstname;
        return $stmt->fetchAll();
    }
} 