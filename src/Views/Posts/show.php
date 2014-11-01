<?php $title = 'Show a Post' ?>

<?php ob_start() ?>
    <div class="jumbotron">
        <!-- Post content-->
        <section id="content" class="body well">

            <article class="hentry">
                <header>
                    <h4 class="entry-title"><?php echo $post->title ?></h4>
                </header>

                <footer class="post-info">
                    <abbr class="published" title="<?php echo($post->created_at); ?>">
                        <?php echo(date('d F Y', strtotime($post->created_at))); ?>
                    </abbr>

                    <address class="vcard author">
                        By <a class="url fn" href="#"><?php echo($post->name); ?></a>
                    </address>
                </footer>

                <div class="entry-content">
                    <p><?php echo plainUrlToLink($post->message); ?></p>
                </div>
            </article>

        </section>

        <hr/>

        <!-- Comments -->
        <section id="comments" class="body">
            <header>
                <h2>Comments</h2>
            </header>
            <?php include 'src/Views/Comments/list.php'; ?>

            <input type="hidden" name="post_id" value="<?php echo $post->id ?>" id="post_id"/>

            <div id="respond">
                <?php include 'src/Views/Comments/create.php'; ?>
            </div>
        </section>

    </div>
<?php $content = ob_get_clean() ?>

<?php include 'src/Views/layout.php' ?>