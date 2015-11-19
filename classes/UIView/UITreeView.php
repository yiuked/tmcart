<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/19
 * Time: 14:45
 */

class UITreeView extends UIView
{

    public static function load()
    {
        $html = '<script type="text/javascript" src="' . BOOTSTRAP_JS . 'bootstrap-treeview.js"></script>' . "\n";
        return $html;
    }

    public function setData()
    {
        $html = '<div class="col-sm-4 col-md-offset-4">
          <h2>Tree</h2>
          <div class="treeview" id="treeview-expandible">
           </div>
        </div>';
        return $html;
    }

    public function draw()
    {
        return $this->setData();
    }
}