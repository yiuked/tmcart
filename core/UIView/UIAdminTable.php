<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/9
 * Time: 19:27
 */

class UIAdminTable extends UIView
{
    /* @var string domclass table 的class值 */
    public $domclass = 'table';

    /* @var string token 当前表格的校验 */
    public $token;

    /* @var string rule 当前页的rule */
    public $rule;

    /* @var string table内部要操作的对象名，比如要ajax更改active的时候，需要用到这个 */
    public $className;

    /* @var int identifier 表主键名 */
    public $identifier;

    /* @var array data 要加载的数据 */
    public $data;

    /* @var bool 如果为true则不跳到edit页，而是跳到子页 */
    public $child = false;

    /* @var bool 显示编辑按钮 */
    public $filters = array();

    /* @var array 表示信息，数组的count决定列数 */
    public $header   = array(
        array('isCheckAll' => 'categoryBox[]','name' => 'id_category'),
        array('sort','name' => 'id_category','title' => 'ID','filter' => 'string'),
        array('sort','name' => 'active','title' => '状态','filter' => 'bool'),
        array('sort','name' => 'position','title' => '排序'),
        array('title' => '操作', 'isAction'=> array('view', 'edit', 'delete')),
    );

    public function __construct($rule, $className, $identifier)
    {
        $this->rule = $rule;
        $this->className = $className;
        $this->identifier = $identifier;
        $this->token =  md5($rule . $className . $identifier);
        $this->addAttribte('class', 'table');
    }

    /**
     * 初始化索引参数
     * @return array self.filters
     */
    public function initFilter()
    {
        global $cookie;

        foreach ($this->header as $head) {
            if (isset($head['filter'])) {
                $key = $this->token . '_' . $head['name'];
                if(isset($_POST[ $key])){
                    $cookie->__set( $key, Tools::P($key));
                    $this->filters[$head['name']] = Tools::P($key);
                }elseif($cookie->__isset($key)){
                    $this->filters[$head['name']] = $cookie->__get($key);
                }
            }
        }

        return $this->filters;
    }

    /**
     * 删除初始filter的cookie记录
     */
    public function unsetFilter()
    {
        global $cookie;

        if (isset($_POST[$this->token . '_resetFilter'])) {
            foreach ($this->header as $head) {
                if (isset($head['filter'])) {
                    $key = $this->token . '_' . $head['name'];
                    if($cookie->__isset($key)){
                        unset($this->{$key});
                    }
                }
            }
        }
    }

    protected function drawHeader()
    {
        if (count($this->header) == 0) {
            return;
        }

        $headHtml = '<tr>';
        $filterHtml = '<tr>';
        $haveFilter = false;
        foreach($this->header as $head){
            $width = isset($head['width']) ? ' width="' . $head['width'] . '" ' : '';
            $class = isset($head['class']) ? ' class="' . $head['class'] . '" ' : '';
            if (isset($head['isCheckAll'])) {
                $headHtml .= '<th><input type="checkbox" data-name="' . $head['isCheckAll'] . '" class="check-all" ></th>';
            }elseif(isset($head['sort']) && $head['sort'] == false){
                $headHtml .= '<th'. $width . $class .'>' . $head['title'] . '</th>';
            }else{
                $headHtml .= '<th'. $width . $class .'>';
                $headHtml .= '<a href="index.php?rule=' . $this->rule . ($this->child ? '&id=' . Tools::G('id') : '') . '&orderby=' . (isset($head['sort']) ? $head['sort'] : $head['name']) . '&orderway=desc&token=' . $this->token . '">';
                $headHtml .= '<span class="glyphicon glyphicon-sort-by-order-alt" aria-hidden="true"></span>';
                $headHtml .= '</a>';
                $headHtml .= $head['title'] ;
                $headHtml .= '<a href="index.php?rule=' . $this->rule . ($this->child ? '&id=' . Tools::G('id') : '') . '&orderby=' . (isset($head['sort']) ? $head['sort'] : $head['name']) . '&orderway=asc&token=' . $this->token . '">';
                $headHtml .= '<span class="glyphicon glyphicon-sort-by-order" aria-hidden="true"></span>';
                $headHtml .= '</a>';
                $headHtml .= '</th>';
            }


            if (isset($head['isAction']) && $haveFilter == true) {
                $filterHtml .=  '<td'. $width . $class .'><div class="btn-group"><button name="' . $this->token . '_submitFilter" type="submit" class="btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-search"></span> 搜索</button>';
                $filterHtml .=  '  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">搜索</span></button>';
                $filterHtml .= '    <ul class="dropdown-menu table-action-dropdown-menu">';
                $filterHtml .= '       <li><button name="' . $this->token . '_resetFilter"  type="submit" class="clear-btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-refresh"></span> 重置</button></li>';
                $filterHtml .= '   </ul></div>';
                $filterHtml .= ' </td>';
            } elseif (!isset($head['filter']) || (isset($head['isAction']) && $haveFilter == false)){
                $filterHtml .= '<td'. $width . $class .'>--</td>';
            } elseif ($head['filter'] == 'string') {
                $haveFilter = true;
                $filterHtml .= '<td'. $width . $class .'><div class="form-group">';
                $filterHtml .= '<label for="' . $this->token . '_' . $head['name'] . '" class="sr-only">' . $head['title'] . '</label>';
                $filterHtml .= '<input type="text" placeholder="' . $head['title'] . '" value="" name="' . $this->token . '_' . $head['name'] . '" class="form-control">';
                $filterHtml .= '</div></td>';
            } elseif ($head['filter'] == 'bool') {
                $filterHtml .= '<td'. $width . $class .'><div class="form-group">';
                $filterHtml .= '<label for="' .$this->token . '_' . $head['name'] . '" class="sr-only">' . $head['title'] . '</label>';
                $filterHtml .= '<select class="form-control" name="' . $this->token . '_' . $head['name'] . '">';
				$filterHtml .= '<option value="">--</option>';
                $filterHtml .= '<option value="1">Yes</option>';
				$filterHtml .= '<option value="2">No</option>';
                $filterHtml .= '</select>';
                $filterHtml .= '</div></td>';
            }
        }

        $headHtml .= '</tr>';
        $filterHtml .= '</tr>';
        return '<thead>'. $headHtml .  $filterHtml . '</thead>';
    }

    protected function drawBody()
    {
        $body = '';
        if (count($this->data) == 0) {
            $body = '<tr><td align="center" colspan="' .count($this->header). '">没有找到有效记录</td></tr>';
        }else{
            foreach ($this->data as $row) {
                $body .= '<tr>';
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
                        }elseif(isset($head['edit']) && $head['edit'] == false){
                            $title = isset($head['color']) ? '<span style="background-color:' .  $row['color'] . ';color:white" class="color_field">' .  $row[$head['name']] . '</span>' : $row[$head['name']];
                            $body .= '<td'. $width . $class .' class="pointer">' .  $title . '</td>';
                        }else{
                            $title = isset($head['color']) ? '<span style="background-color:' .  $row['color'] . ';color:white" class="color_field">' .  $row[$head['name']] . '</span>' : $row[$head['name']];
                            $body .= '<td'. $width . $class .' onclick="document.location = \'index.php?rule=' .  $this->rule . (!$this->child ? '_edit' : '') . '&id=' .  $row[$this->identifier] . '\'" class="pointer">' .  $title . '</td>';
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
                                $body .= '<a href="index.php?rule=' .  $this->rule . '&delete=' .  $row[$this->identifier] . '" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a>';
                                break;
                        }

                        $body .=  '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">操作</span></button>';
                        $body .=  '<ul class="dropdown-menu table-action-dropdown-menu">';
                        foreach ($head['isAction'] as $key => $action) {
                            if ($key == 0) {
                                continue;
                            }
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
        $table = '<table '. $this->drawAttribute() .'>' . $this->drawHeader() .  $this->drawBody() . '</table>';
        return $table;
    }

}