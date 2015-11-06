<?php
/**
 * 2010-2015 Yiuked
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to yiuked@vip.qq.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade yiukedautoseo to newer
 * versions in the future.
 *
 * @author    Yiuked SA <yiuked@vip.qq.com>
 * @copyright 2010-2015 Yiuked
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class AdminBreadcrumb
{
    private $breadcrumbs = array();
    private $customClass = 'custom';


    public static function getInstance()
    {
        $breadcrumb = new AdminBreadcrumb();
        return $breadcrumb;
    }
    public function home()
    {
        $array = array(
          'href' => 'index.php',
          'title'=> '面板',
            'icon' => 'home'
        );
        $this->breadcrumbs[] = $array;
        return $this;
    }
    public function add($array)
    {
        $this->breadcrumbs[] = $array;
        return $this;
    }

    public function setCustomClass($customClass)
    {
        $this->customClass = $customClass;
    }

    public function generate()
    {
        $html = '<ol class="breadcrumb ' . (!empty($this->customClass) ? $this->customClass : '') . '">';
        foreach ($this->breadcrumbs as $breadcrumb) {
            $html .= '<li' .(isset($breadcrumb['active']) ? ' class="active"' : '').'>';
            $html .= (isset($breadcrumb['icon']) ? '<span class="glyphicon glyphicon-' . $breadcrumb['icon']  . '"></span> ':'');
            $html .= (isset($breadcrumb['href']) ? '<a href="' . $breadcrumb['href']  . '">' . $breadcrumb['title']  . '</a>':$breadcrumb['title']);
            $html .= '</li>';
        }
        $html .= '</ol>';
        return $html;
    }
}