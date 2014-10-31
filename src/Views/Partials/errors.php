<?php
if (isset($message) && $message != '')
{
    ?>
    <div class="alert alert-block alert-<?php echo $messageType ?>">
        <button type="button" class="close" data-dismiss="alert"><i class="icon icon-remove"></i></button>
        <i class="icon-warning-sign orange"></i> <strong>Message!</strong>
        <ul id="form-errors">
            <?php echo $message; ?>
        </ul>
    </div>
<?php
}
?>