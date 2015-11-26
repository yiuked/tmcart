<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $data['title']; ?>
            </div>
            <div class="panel-body">
                <form class="form" method="post" action="index.php?rule=<?php echo isset($data['action']) ? $data['action'] : Tools::G('rule');?>">
                    <?php
                    //config table options
                    $data['table']->data = $data['result']['entitys'];
                    echo  $data['table']->draw();
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" value="<?php echo $data['table']->token;?>" name="token">
                            <?php
                            if (isset($data['btn_groups']) && count($data['btn_groups']) > 0) {
                                foreach ($data['btn_groups'] as $item) {
                                    $id = isset($item['id']) ? ' id="' . $item['id'] . '"' : '';
                                    $name = isset($item['name']) ? ' name="' . $item['name'] . '"' : '';
                                    $type = isset($item['btn_type']) ? ' type="' . $item['btn_type'] . '"' : '';
                                    $confirm = isset($item['confirm']) ? ' onclick="return confirm(\'' . $item['confirm'] . '\');"' : '';
                                    $icon = isset($item['icon']) ? '<span aria-hidden="true" class="glyphicon glyphicon-' . $item['icon'] . '"></span>' : '';
                                    ?>
                                    <?php if ($item['type'] == 'a') { ?>
                                        <a href="<?php echo $item['href']; ?>"
                                           class="btn <?php echo $item['class']; ?>" <?php echo $id . $confirm . $name; ?>>
                                            <?php echo $icon . $item['title']; ?>
                                        </a>
                                    <?php } else { ?>
                                        <button
                                            class="btn <?php echo $item['class']; ?>" <?php echo $id . $confirm . $name . $type; ?>>
                                            <?php echo $icon . $item['title']; ?>
                                        </button>
                                    <?php } ?>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $pagination = new UIAdminPagination($data['result']['total'], $data['limit']);
                            echo $pagination->draw();
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>