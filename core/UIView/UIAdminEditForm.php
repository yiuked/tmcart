<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/30
 * Time: 12:20
 */

class UIAdminEditForm extends UIView
{
    /** @var array  要加截的表单内容 */
    public $items = array();

    /**
     * 初始化表单
     *
     * @param $method
     * @param $action
     * @param null $class
     * @param null $id
     * @param null $enctype
     */
    public function __construct($method, $action, $class = null, $id = null, $enctype = null)
    {
        $this->attribtes['method'] = $method;
        $this->attribtes['action'] = $action;
        if ($id) {
            $this->attribtes['id'] = $id;
        }
        if ($class) {
            $this->attribtes['class'] = $class;
        }
        if ($enctype) {
            $this->attribtes['enctype'] = $enctype;
        }
    }

    /**
     * 绘制表单内容
     * @return string|void
     */
    public function drawBody()
    {
        if (!is_array($this->items) || count($this->items) == 0) {
            return;
        }

        $html = '';
        foreach ($this->items as $key => $item) {

            $class = 'class="form-control ' . (isset($item['class']) ? ' ' . $item['class'] . '"' : '"');
            $info  = isset($item['info']) ? '<p class="text-info">' . $item['info'] .'</p>': '';
            $other = isset($item['other']) ? ' ' . $item['other'] : '';
            $id    = isset($item['id']) ? ' id=' . $item['id'] : '';
            $style = isset($item['css']) ? ' style=' . $item['css'] : '';

            if (in_array($item['type'], array('text', 'passwd', 'email'))) {
                $html .= '<div class="form-group">
                    <label class="col-md-2 control-label" for="' .$key . '">' . $item['title'] . '</label>
                    <div class="col-md-8">
                        <input type="' . $item['type'] . '" value="' . $item['value'] . '" name="' . $key . '" ' . $class . $id . $style . $other . '>
                        '.  $info .'
                    </div>
                </div>';
            } elseif ($item['type'] == 'hidden') {
                $html .= '<input type="hidden" value="' . $item['value'] . '"  name="' . $key . '">';
            } elseif ($item['type'] == 'submit' || $item['type'] == 'cannel') {
                $html .= '<div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button name="' . $key . '" class="btn ' . $item['class'] . '" type="' . $item['type'] . '"><span class="glyphicon ' . $item['icon'] . '"></span> ' . $item['title'] . '</button>
                    </div>
                </div>';
            } elseif ($item['type'] == 'select') {
                $options = '';
                if (isset($item['option'])) {
                    foreach ($item['option'] as $k => $val) {
                        $options .= '<option value="' . $k . '" '.(isset($item['value']) && $item['value'] == $k ? 'selected="selected"' : '').'>' . $val . '</option>';
                    }
                }
                $html .= '<div class="form-group">
                    <label class="col-md-2 control-label" for="' .$key . '">' . $item['title'] . '</label>
                    <div class="col-md-8">
                        <select name="' . $key . '" ' . $class . $id . $style . $other . '>
                            <option value="NULL">--选择--</option>
                            '. $options .'
                        </select>
                        '.  $info .'
                    </div>
                </div>';
            }

            unset($class);
            unset($info);
            unset($other);
            unset($id);
            unset($style);
        }

        return $html;
    }

    public function draw()
    {
        return '<form '. $this->drawAttribute() .'>' .  $this->drawBody() . '</form>';
    }
}