<?php $title = 'List of Posts' ?>

<?php ob_start() ?>
    <div class="jumbotron">
        <?php include 'src/Views/Partials/messages.php'; ?>

        <h3>List of Posts</h3>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <a href="/show?id=<?php echo $post->id ?>">
                        <?php echo $post->title ?>
                    </a>
                    - By: <?php echo $post->name ?> - on: <?php echo $post->created_at ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php $content = ob_get_clean() ?>

<?php include 'src/Views/layout.php' ?>