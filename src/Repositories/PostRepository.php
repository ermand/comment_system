<?php namespace App\Repository;

use App\Models\Post;
use DateTime;

class PostRepository extends BaseRepository {

    private static $tableName = 'posts';
    private static $modelClass = 'App\Models\Post';

    protected function getTableName()
    {
        return self::$tableName;
    }

    protected function getModelClass()
    {
        return self::$modelClass;
    }

    public function save(Post $post)
    {
        // If the ID is set, we're updating an existing record
        if (isset($post->id)) {
            return $this->update($post);
        }

        $stmt = $this->connection->prepare('
            INSERT INTO ' . self::$tableName . '
                (name, email, title, message, created_at)
            VALUES
                (:name, :email, :title, :message, :created_at)
        ');
        $stmt->bindParam(':name', $post->name);
        $stmt->bindParam(':email', $post->email);
        $stmt->bindParam(':title', $post->title);
        $stmt->bindParam(':message', $post->message);
        $stmt->bindParam(':created_at', (new DateTime())->format('Y-m-d H:i:s'));
        return $stmt->execute();
    }

    public function update(Post $post)
    {
        if (!isset($post->id)) {
            // We can't update a record unless it exists...
            throw new \LogicException(
                'Cannot update post that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare('
            UPDATE ' . self::$tableName . '
            SET name = :name,
                email = :email,
                message = :message
            WHERE id = :id
        ');
        $stmt->bindParam(':name', $post->name);
        $stmt->bindParam(':email', $post->email);
        $stmt->bindParam(':message', $post->message);
        $stmt->bindParam(':id', $post->id);
        return $stmt->execute();
    }
} 