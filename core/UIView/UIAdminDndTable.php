<?php
/**
 * 使用dndtable时，必要设置table的id属性
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 18:09
 */

class UIAdminDndTable extends UIAdminTable
{
    public $parent = '';

    public static function loadHead()
    {
       $head =  '<script type="text/javascript" src="' . _TM_JQ_URL . '/jquery.tablednd_0_5.js"></script>';
       $head .= '<script src="' . _TM_JS_ADM_URL . 'dnd.js" type="text/javascript"></script>';
        return $head;
    }

    protected function drawBody()
    {
        global $link;

        $body = '';
        if (count($this->data) == 0) {
            $body = '<tr><td align="center" colspan="' .count($this->header). '">没有找到有效记录</td></tr>';
        }else{
            foreach ($this->data as $key => $row) {
                $path = !empty($this->parent) ? $row[$this->parent] . '_' : '';
                $path .= $row[$this->identifier];
                $body .= '<tr id="tr_' . $path . '_' . $row['position'] . '" >';
                foreach($this->header as $head){
                    $width = isset($head['width']) ? ' width="' . $head['width'] . '" ' : '';
                    $class = isset($head['class']) ? ' class="' . $head['class'] . '" ' : '';
                    if (isset($head['isCheckAll'])) {
                        $body .= '<td><input type="checkbox" name="' . $head['isCheckAll']. '" value="' . $row[$this->identifier]. '" ></td>';
                    } elseif (isset($head['name'])) {
                        if (isset($head['isImage'])) {
                            $body .= '<td'. $width . $class .'><img src="' .  $row[$head['name']] . '" class="img-thumbnail"></td>';
                        } elseif (isset($head['filter']) && $head['filter'] == 'bool') {
                            $body .= '<td'. $width . $class .'><span class="glyphicon glyphicon-'. ($row[$head['name']] == 0 ? 'remove':'ok') .' active-toggle" onclick="setToggle($(this),\'' .  $this->className . '\',\'' .  $head['name'] . '\',' .  $row[$this->identifier] . ')"></span></td>';
                        }elseif ($head['name'] == 'position'){
                            $body .= '<td'. $width . $class .' id="td_' . $path .'" class="pointer dragHandle center" >';
                            $body .= '<div class="dragGroup"><span aria-hidden="true" class="glyphicon glyphicon-move"></span> <span class="positions">' . $row['position'] . '</span></div>';
                            $body .= '</td>';
                        }elseif(isset($head['edit']) && $head['edit'] == false){
                            $title = isset($head['color']) ? '<span style="background-color:' .  $row['color'] . ';color:white" class="color_field">' .  $row[$head['name']] . '</span>' : $row[$head['name']];
                            $body .= '<td'. $width . $class .' class="pointer">' .  $title . '</td>';
                        }else {
                            $rule = isset($head['rule']) ? $head['rule'] : $this->rule . '_edit';
                            $title = isset($head['color']) ? '<span style="background-color:' .  $row['color'] . ';color:white" class="color_field">' .  $row[$head['name']] . '</span>' : $row[$head['name']];
                            $body .= '<td'. $width . $class .' onclick="document.location = \'index.php?rule=' .  $rule . '&id=' .  $row[$this->identifier] . '\'" class="pointer">' .   $title . '</td>';
                        }
                    } elseif (isset($head['isAction'])) {
                        //create filter and reset filter buttom group
                        $body .=  '<td'. $width . $class .'><div class="btn-group">';
                        switch ($head['isAction'][0]) {
                            case 'view':
                                $body .= '<a class="btn btn-default" href="' .Tools::getLink($row['rewrite']). '"><span class="glyphicon glyphicon-file" title="查看" aria-hidden="true"></span> 查看</a>';
                                break;
                            case 'edit':
                                $body .= '<a class="btn btn-default" href="index.php?rule=' .  $this->rule . '_edit&id=' .  $row[$this->identifier] . '"><span class="glyphicon glyphicon-edit" title="编辑" aria-hidden="true"></span> 编辑</a>';
                                break;
                            case 'delete':
                                $body .= '<a class="btn btn-default" href="index.php?rule=' .  $this->rule . ($this->child ? '&id=' . Tools::G('id') : '')  . '&delete=' .  $row[$this->identifier] . '" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a>';
                                break;
                        }
                        if (count($head['isAction']) == 1){
                            $body .=  '</div></td>';
                            continue;
                        }
                        $body .=  '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">操作</span></button>';
                        $body .=  '<ul class="dropdown-menu table-action-dropdown-menu">';
                        foreach ($head['isAction'] as $key => $action) {
                            if ($key == 0) {
                                continue;
                            }
                            if ($action == 'view') {
                                $body .=  '<li><a href="' .$link->getPage($this->className . 'View', $row[$this->identifier]). '" target="_blank"><span class="glyphicon glyphicon-file" title="查看" aria-hidden="true"></span> 查看</a></li>';
                            }
                            if ($action == 'edit') {
                                $body .=  '<li><a href="index.php?rule=' .  $this->rule . '_edit&id=' .  $row[$this->identifier] . '"><span class="glyphicon glyphicon-edit" title="编辑" aria-hidden="true"></span> 编辑</a></li>';
                            }
                            if ($action == 'delete') {
                                $body .=  '<li><a href="index.php?rule=' .  $this->rule . ($this->child ? '&id=' . Tools::G('id') : '')  . '&delete=' .  $row[$this->identifier] . '" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a></li>';
                            }
                        }

                        $body .=  '</ul></div></td>';
                    }
                }
                $body .= '</tr>';
            }
        }

        return '<tbody>' . $body .  '</tbody>';
    }

    public function draw()
    {
        $this->addAttribte('class', $this->getAttribute('class') . ' tableDnD');
        $table = '<table '. $this->drawAttribute() .'>' . $this->drawHeader() .  $this->drawBody() . '</table>';
        return $table;
    }
}