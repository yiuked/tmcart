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

$extendsDir = false;
require_once(_TM_CACHE_DIR . 'class_index.php');
function __autoload ($className)
{
    global $extendsDir, $class_index;
    if (isset($class_index[$className]) && file_exists($class_index[$className])){
        require_once($class_index[$className]);
    }else{
        if (file_exists(_TM_CLASS_DIR . $className . '.php')) {
            require_once(_TM_CLASS_DIR . $className . '.php');
            $class_index[$className] = _TM_CLASS_DIR . $className . '.php';
        } elseif (file_exists(_TM_VIEWS_DIR . $className . '.php')) {
            require_once(_TM_VIEWS_DIR . $className . '.php');
            $class_index[$className] = _TM_VIEWS_DIR . $className . '.php';
        } elseif (file_exists(_TM_CORE_DIR . $className . '.php')) {
            require_once(_TM_CORE_DIR . $className . '.php');
            $class_index[$className] = _TM_CORE_DIR . $className . '.php';
        } else {
            if (!$extendsDir) {
                getExtendsDir(_TM_CORE_DIR,$extendsDir);
                getExtendsDir(_TM_CLASS_DIR,$extendsDir);
            }
            $haveClass = false;
            foreach ($extendsDir as $dir ){
                if (file_exists($dir . $className . '.php')) {
                    require_once($dir . $className . '.php');
                    $class_index[$className] = $dir . $className . '.php';
                    $haveClass = true;
                    break;
                }
            }
            if (!$haveClass) {
                die('Class \'' . $className . '\' not found!');
            }
        }
        file_put_contents(_TM_CACHE_DIR . 'class_index.php', "<?php\n \$class_index = ". var_export($class_index, true) ."; \n");
    }
}

function getExtendsDir($path,&$dirs)
{
    if(is_dir($path)){
        $dp = dir($path);
        while ($file = $dp ->read()){
            if($file !="." && $file !=".."){
                getExtendsDir($path.$file."/", $dirs);
            }
        }
        $dp ->close();
    }
    if(is_dir($path)){
        $dirs[] =  $path;
    }
}