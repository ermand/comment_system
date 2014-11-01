<?php $title = 'Create new Post'; ?>

<?php ob_start(); ?>
    <div class="jumbotron">
        <h3>Create New Post</h3>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'fail'): ?>
            <h4 class="error-message">Validation failed!</h4>
        <?php endif; ?>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'spam'): ?>
            <h4 class="error-message">Sorry spammer! You are not allowed to post.</h4>
        <?php endif; ?>

        <?php include 'src/Views/Partials/messages.php'; ?>

        <form action="/create" method="POST" class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="name">Name</label>
                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo getCurrentValue('name'); ?>" pattern=".{4,}" required title="4 characters minimum" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="email">Email</label>
                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
                    <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo getCurrentValue('email'); ?>" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="title">Title</label>
                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
                    <input type="text" name="title" placeholder="Title" class="form-control" value="<?php echo getCurrentValue('title'); ?>" pattern=".{5,}" required title="5 characters minimum" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="message">Message</label>
                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
                    <textarea name="message" class="form-control" value="<?php echo getCurrentValue('message'); ?>"  id="message" rows="6" placeholder="Message" pattern=".{20,}" required title="20 characters minimum" required="required"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label  class="col-lg-8 col-md-8 col-sm-8 col-xs-8 control-label" for="enable"> Please Check this box to confirm you are human :)</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="checkbox" name="enable" id="enable" class="enable_checkbox">
                </div>
            </div>

            <input type="checkbox" name="interested" class="form-control">

            <hr/>

            <div class="form-group center">
                <div class="col-lg-offset-4 col-lg-6">
                    <button class="btn btn-lg btn-info ladda-button" name="submit" type="submit" data-style="expand-right" id="submit">
                        <i class="icon-ok bigger-110"></i>
                        <span class="ladda-label">Post</span>
                    </button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn btn-lg" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php $content = ob_get_clean(); ?>

<?php include 'src/Views/layout.php' ?>
