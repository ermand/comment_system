<?php namespace App\Repository;

use App\Models\Comment;
use DateTime;

class CommentRepository extends BaseRepository {

    /**
     * @var string
     */
    private static $tableName = 'comments';
    /**
     * @var string
     */
    private static $modelClass = 'App\Models\Comment';

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
     * Get model class.
     *
     * @return string
     */
    protected function getModelClass()
    {
        return self::$modelClass;
    }

    /**
     * Save object into database.
     *
     * @param Comment $comment
     * @return bool
     */
    public function save(Comment $comment)
    {
        // If the ID is set, we're updating an existing record
        if (isset($comment->id)) {
            return $this->update($comment);
        }

        $stmt = $this->connection->prepare('
            INSERT INTO ' . self::$tableName . '
                (post_id, name, email, message, created_at)
            VALUES
                (:post_id, :name, :email, :message, :created_at)
        ');
        $stmt->bindParam(':post_id', $comment->post_id);
        $stmt->bindParam(':name', $comment->name);
        $stmt->bindParam(':email', $comment->email);
        $stmt->bindParam(':message', plainUrlToLink($comment->message));
        $stmt->bindParam(':created_at', (new DateTime())->format('Y-m-d H:i:s'));
        return $stmt->execute();
    }

} 