<div class="row">
    <div class="<?php echo isset($data['class']) ? $data['class'] : 'col-md-12';?>">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <?php
                        if (isset($data['bread'])) {
                            echo $data['bread'];
                        }
                    ?>
                </div>
                <?php if (isset($data['btn_groups'])) {?>
                <div class="col-md-6">
                    <div class="save-group pull-right" role="group">
                    <?php foreach($data['btn_groups'] as $item){ ?>
                        <?php if($item['type'] == 'a'){ ?>
                            <a href="<?php echo $item['href'];?>"  class="btn <?php echo $item['class'];?>" <?php echo isset($item['id']) ? 'id="' .$item['id']. '"' : '';?>>
                            <span aria-hidden="true" class="glyphicon glyphicon-<?php echo $item['icon'];?>"></span>
                            <?php echo $item['title'];?>
                            </a>
                        <?php }else{ ?>
                            <button  class="btn <?php echo $item['class'];?>" <?php echo isset($item['id']) ? 'id="' .$item['id']. '"' : '';?>>
                                <span aria-hidden="true" class="glyphicon glyphicon-<?php echo $item['icon'];?>"></span>
                                <?php echo $item['title'];?>
                            </button>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>