<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/10
 * Time: 18:55
 */

class UIAdminPagination extends  UIView
{
    private $currentLimit;
    private $total;
    public $limits = array(20,50,100,300);
    public $pageKey = 'p';
    public $showPage = 5;
    public $currentPageBefor = 3;

    public function __construct($total, $currentLimit)
    {
        $this->total = (int)$total;
        $this->currentLimit = (int)$currentLimit;
    }

    private function drawLimit()
    {
        $limitHtml = '<div class="pull-left">';
        $limitHtml .= '    <span class="page-number-title pull-left">共 <strong>' .$this->total . '</strong> 条记录,每页显示</span>';
        $limitHtml .= '    <select onchange="submit()" name="pagination" class="form-control page-number-select pull-left">';
        foreach ($this->limits as $limit) {
            $limitHtml .= '<option value="' . $limit . '" '. ($limit == $this->currentLimit ? 'selected="selected"' : '') . '>' . $limit . '</option>';
        }
         $limitHtml .= '    </select>';
         $limitHtml .= '</div>';
        return  $limitHtml;
    }

    private function drawPagination()
    {
        $args = $_GET;
        $p    = isset($_GET[$this->pageKey]) ? (int)$_GET[$this->pageKey] : 1;

        $html 	= '<ul class="pagination">';
        $pagesNB 	= ceil($this->total / $this->currentLimit);

        if ($p !=1 ) {
            $args[$this->pageKey] = $p - 1;
            $argstr = http_build_query($args);
            $html .= '<li><a href="index.php?'.$argstr.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }else{
            $html .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        if ($pagesNB < $this->showPage) {
            for ($i = 1; $i <= $pagesNB; $i++) {
                $args[$this->pageKey] = $i;
                $argstr = http_build_query($args);
                $html .= '<li'.($p == $i?' class="active"':'').'><a href="index.php?'.$argstr.'">'.$i.'</a></li>';
            }
        } elseif ($p <= $this -> currentPageBefor) {
            for ($i = 1; $i <= $this->showPage; $i++) {
                $args[$this->pageKey] = $i;
                $argstr = http_build_query($args);
                $html .= '<li'.($p == $i?' class="active"':'').'><a href="index.php?'.$argstr.'">'.$i.'</a></li>';
            }
        } elseif (($pagesNB - $p) <= $this -> currentPageBefor) {
            for ($i = $pagesNB - $this->showPage + 1; $i<= $pagesNB; $i++) {
                $args[$this->pageKey] = $i;
                $argstr = http_build_query($args);
                $html .= '<li'.($p == $i?' class="active"':'').'><a href="index.php?'.$argstr.'">'.$i.'</a></li>';
            }
        } else {
            for ($i = $p - $this -> currentPageBefor; $i<= $p + $this->showPage - $this -> currentPageBefor; $i++) {
                $args[$this->pageKey] = $i;
                $argstr = http_build_query($args);
                $html .= '<li'.($p == $i?' class="active"':'').'><a href="index.php?'.$argstr.'">'.$i.'</a></li>';
            }
        }

        if ($pagesNB > 1 AND $p != $pagesNB) {
            $args[$this->pageKey] = $p + 1;
            $argstr = http_build_query($args);
            $html .= '<li><a href="index.php?'.$argstr.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }else{
            $html .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }

        $html 	.= '</ul>';
        return $html;
    }

    public function draw()
    {
        $limit = $this->drawLimit();
        $pagination = $this->drawPagination();

        return '<nav class="page-number">' . $limit .$pagination . '</nav>';
    }
}