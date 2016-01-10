<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 17:09
 */

abstract class UIView implements UIViewInterface
{

    /* @var array $attribte 用于存放所创建view的键值属性 如id ,class */
    public $attribtes = array();

    abstract public function draw();

    /**
     * 添加属性
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addAttribte($key, $value)
    {
        $this->attribtes[$key] = $value;
        return $this;
    }

    /**
     * 获取属性
     *
     * @param $key
     */
    public function getAttribute($key){
        return $this->attribtes[$key];
    }

    /**
     * 绘制属性
     *
     * @return string
     */
    protected function drawAttribute()
    {
        $attribute = '';
        if (is_array($this->attribtes) && count($this->attribtes) > 0) {
            foreach ($this->attribtes as $key => $value) {
                $attribute .= $key . '="' . $value . '" ';
            }
        }
        return $attribute;
    }

}