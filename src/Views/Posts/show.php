<?php $title = 'Show a Post' ?>

<?php ob_start() ?>
    <div class="jumbotron">
        <section id="content" class="body">

            <article class="hentry">
                <header>
                    <h4 class="entry-title"><?php echo $post->title ?></h4>
                </header>

                <footer class="post-info">
                    <abbr class="published" title="2012-02-10T14:07:00-07:00">
                        <?php echo $post->created_at ?>
                    </abbr>

                    <address class="vcard author">
                        By <?php echo $post->name ?>
                    </address>
                </footer>

                <div class="entry-content">
                    <p><?php echo $post->message ?></p>
                </div>
            </article>

        </section>

        <hr/>

        <!-- Comments -->
        <section id="comments" class="body">
            <header>
                <h2>Comments</h2>
            </header>

            <ol id="posts-list" class="hfeed">
                <li>
                    <article id="comment_1" class="hentry">
                        <footer class="post-info">
                            <abbr class="published" title="Thu, 23 Feb 2012 23:54:46 +0000">
                                23 February 2012
                            </abbr>

                            <address class="vcard author">
                                By <a class="url fn" href="#">Phil Leggetter</a>
                            </address>
                        </footer>
                    </article>
                </li>
            </ol>

            <div id="respond">
                <?php require 'src/Views/Comments/create.php'; ?>
            </div>
        </section>

    </div>
<?php $content = ob_get_clean() ?>

<?php include 'src/Views/layout.php' ?>