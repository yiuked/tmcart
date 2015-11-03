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
    private $steps = array();
    private $home;

    public function add($rule,$title)
    {
        $this->steps[$rule] = $title;
        return $this;
    }

    public function last($title)
    {
        $html = '<ol class="breadcrumb">';
        if (empty($this->home)) {
            $html .= '<li><a href="index.php">后台首页</a></li>';
        } else {
            $html .= '<li><a href="index.php">' . $home . '</a></li>';
        }
        foreach ($this->steps as $rule => $title) {
            $html .= '<li><a href="index.php?rule=' . $rule . '">' .$title. '</a></li>';
        }

        $html .= '<li class="active">' .$title. '</li>';
        $html .= '</ol>';
        return $html;
    }
}