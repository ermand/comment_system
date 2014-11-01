<?php if (isset($_SESSION['message']) && $_SESSION['message'] != ''): ?>
    <div class="alert alert-block alert-<?php echo $_SESSION['messageType'] ?>">
        <button type="button" class="close" data-dismiss="alert"><i class="icon icon-remove"></i></button>
        <i class="icon-warning-sign orange"></i> <strong>Message!</strong>
        <ul id="form-errors">
            <?php echo $_SESSION['message']; ?>
        </ul>
    </div>
<?php endif; ?>