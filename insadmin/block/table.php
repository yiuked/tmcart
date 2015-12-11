<?php
/**
 * $data 为一个数组
 * $data['title'] 为表头信息
 * $data['result'] 为一个二维数组，包含entitys与total,分别代表加载的数据，与数据总量
 * $data['btn_groups'] 为低部的button按钮,按钮可按下以方式编写
 * array(
 * 'type' => 'a', //or 'button' if eq 'q' the href is require
 * 'id' => 'string', //dom id
 * 'name' => 'string',
 * 'icon' => 'string', //添加一个bootrstap图标
 * 'confirm' => 'string',//为对象添加一个click 事件，事件调用confirm函数，confirm的内容为这个value值
 * 'title' => 'string',
 * 'class' => 'string',
 * 'btn_type' => 'string' 按钮的类型，如submit,button
 * )
 * $data['limit'] int型，每页显示数量，无该项的时候，则不调用分页
 *
 * */
?>
<div class="row">
    <div class="<?php echo isset($data['class']) ? $data['class'] : 'col-md-12';?>">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="badge"><?php echo $data['result']['total'];?></span> <?php echo $data['title']; ?>
            </div>
            <div class="panel-body">
                <form class="form" method="post" action="index.php?rule=<?php echo isset($data['action']) ? $data['action'] : Tools::G('rule');?>">
                    <?php
                    //config table options
                    $data['table']->data = $data['result']['items'];
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
                        <?php if (isset($data['limit'])) {?>
                        <div class="col-md-6">
                            <?php
                            $pagination = new UIAdminPagination($data['result']['total'], $data['limit']);
                            echo $pagination->draw();
                            ?>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>