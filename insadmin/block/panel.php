<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/30
 * Time: 15:30
 */
?>
<?php if (!isset($data['row']) || (isset($data['row']) && $data['row'] == true)) { ?>
<div class="row">
<?php } ?>
    <div class="<?php echo isset($data['class']) ? $data['class'] : 'col-md-12'; ?>">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $data['title']; ?>
            </div>
            <div class="panel-body">
                <?php echo $data['body']; ?>
            </div>
        </div>
    </div>
<?php if (!isset($data['row']) || (isset($data['row']) && $data['row'] == true)) { ?>
</div>
<?php } ?>
