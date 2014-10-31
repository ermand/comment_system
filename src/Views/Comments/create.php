<h3>Leave a Comment</h3>

<form action="" method="post" class="form-horizontal">

    <?php include(viewPartialsPath() . 'errors.php'); ?>

    <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="name">Name</label>
        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
            <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo getCurrentValue('name'); ?>" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="email">Email</label>
        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
            <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo getCurrentValue('email'); ?>" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label" for="message">Message</label>
        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7">
            <textarea name="message" class="form-control" value="<?php echo getCurrentValue('message'); ?>"  id="message" rows="6" tabindex="4" placeholder="Message" required="required"></textarea>
        </div>
    </div>

    <hr/>

    <div class="form-group center">
        <div class="col-lg-offset-4 col-lg-6">
            <button class="btn btn-lg btn-success" name="submit" type="submit" data-style="expand-right">
                <i class="icon-ok bigger-110"></i> Leave Comment
            </button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn btn-lg" type="reset">
                <i class="icon-undo bigger-110"></i> Reset
            </button>
        </div>
    </div>
</form>
