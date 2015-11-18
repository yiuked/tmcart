<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/17
 * Time: 14:52
 */
//
if (!defined('ADMIN_BLOCK_DIR')) {
    exit;
}

class UIViewBlock
{
    /**
     * @param $data
     * @param $tpl
     * @return string
     */
    public static function area($data, $tpl)
    {
        $tplFile = ADMIN_BLOCK_DIR . $tpl;
        if (Tools::getFileType($tplFile) != 'php') {
            $tplFile .= '.php';
        }

        if (file_exists($tplFile)) {
            ob_start();
            include($tplFile);
            $html = ob_get_contents();
            ob_end_clean();
           return $html;
        }

    }
}