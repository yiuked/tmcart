<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 18:09
 */

class UIAdminDndTable extends UIAdminTable
{
    public $parent = '';

    protected function drawBody()
    {
        $body = '';
        if (count($this->data) == 0) {
            $body = '<tr><td align="center" colspan="' .count($this->header). '">没有找到有效记录</td></tr>';
        }else{
            foreach ($this->data as $key => $row) {
                $path = !empty($this->parent) ? $row[$this->parent] . '_' : '';
                $path .= $row[$this->identifier];
                $body .= '<tr id="tr_' . $path . '_' . $row['position'] . '">';
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
                            $body .= '<a href="index.php?rule=' . $this->rule . (!empty($this->parent) ? '&move_'. $this->parent . '=' . $row[$this->parent]: ''). '&move_' .$this->identifier . '=' . $row[$this->identifier] .'&way=1&position=' .($row['position'] + 1). '" ' .($key + 1 == count($this->data) ? 'style="display:none"' : '') . '>';
                            $body .= '<span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span></a>';
                            $body .= '<a href="index.php?rule=' . $this->rule . (!empty($this->parent) ? '&move_'. $this->parent . '=' . $row[$this->parent]: ''). '&move_' .$this->identifier . '=' . $row[$this->identifier] .'&way=0&position=' .($row['position'] - 1). '" ' .($key == 0 ? 'style="display:none"' : '') . '>';
                            $body .= '<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></a>';
                            $body .= '</td>';
                        }else {
                            $body .= '<td'. $width . $class .' onclick="document.location = \'index.php?rule=' .  $this->rule . (!$this->child ? '_edit' : '') . '&id=' .  $row[$this->identifier] . '\'" class="pointer">' .  $row[$head['name']] . '</td>';
                        }
                    } elseif (isset($head['isAction'])) {
                        //create filter and reset filter buttom group
                        $body .=  '<td'. $width . $class .'><div class="btn-group">';
                        $body .=  '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">操作 <span aria-hidden="true" class="glyphicon glyphicon-collapse-down"></span></button>';
                        $body .=  '<ul class="dropdown-menu table-action-dropdown-menu">';
                        foreach ($head['isAction'] as $action) {
                            if ($action == 'view') {
                                $body .=  '<li><a href="' .Tools::getLink($row['rewrite']). '" target="_blank"><span class="glyphicon glyphicon-file" title="查看" aria-hidden="true"></span> 查看</a></li>';
                            }
                            if ($action == 'edit') {
                                $body .=  '<li><a href="index.php?rule=' .  $this->rule . '_edit&id=' .  $row[$this->identifier] . '"><span class="glyphicon glyphicon-edit" title="编辑" aria-hidden="true"></span> 编辑</a></li>';
                            }
                            if ($action == 'delete') {
                                $body .=  '<li><a href="index.php?rule=' .  $this->rule . '&delete=' .  $row[$this->identifier] . '" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a></li>';
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
        $header = $this->drawHeader();
        $body   = $this->drawBody();
        $table = '<table class="table tableDnD"' . ' id="'.strtolower($this->className).'" >' . $header .  $body . '</table>';
        return $table;
    }
}