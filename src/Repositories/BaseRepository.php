<?php namespace App\Repository;

use PDO;

abstract class BaseRepository {

    protected $connection;

    /**
     * A getTableName method is required.
     *
     * @return mixed
     */
    abstract protected function getTableName();

    /**
     * A getModelClass method is required.
     *
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        if ($this->connection === null) {
            $this->connection = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
    }

    /**
     * Find record in database by id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $stmt = $this->connection->prepare('
            SELECT ' . $this->getTableName() . '.*
             FROM ' . $this->getTableName() . '
             WHERE id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());

        return $stmt->fetch();
    }

    /**
     * Get all record from database.
     *
     * @return array
     */
    public function findAll()
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM ' . $this->getTableName() . '
        ');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());

        return $stmt->fetchAll();
    }

    /**
     * Find record in database by column name, value and operator.
     *
     * @param $columnName
     * @param $value
     * @param null $operator
     * @param null $orderByColumn
     * @param null $orderBy
     * @return array
     */
    public function findByColumn($columnName, $value, $operator = NULL, $orderByColumn = NULL, $orderBy = NULL)
    {
        $operator = is_null($operator) ? '=' : $operator;
        $orderByColumn = is_null($orderByColumn) ? 'id' : $orderByColumn;
        $orderBy = is_null($orderBy) ? 'ASC' : $orderBy;

        $stmt = $this->connection->prepare('
            SELECT ' . $this->getTableName() . '.*
             FROM ' . $this->getTableName() . '
             WHERE ' . $columnName . ' ' . $operator . '  :column
            ORDER BY ' . $orderByColumn . ' ' . $orderBy . '
        ');
        $stmt->bindParam(':column', $value);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());

        return $stmt->fetchAll();
    }
} 