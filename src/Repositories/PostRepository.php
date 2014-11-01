<?php namespace App\Repository;

use App\Models\Post;
use DateTime;

class PostRepository extends BaseRepository {

    private static $tableName = 'posts';
    private static $modelClass = 'App\Models\Post';

    /**
     * Get table name.
     *
     * @return string
     */
    protected function getTableName()
    {
        return self::$tableName;
    }

    /**
     * Get class of model.
     *
     * @return string
     */
    protected function getModelClass()
    {
        return self::$modelClass;
    }

    /**
     * Save object to database.
     *
     * @param Post $post
     * @return bool
     */
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

} 