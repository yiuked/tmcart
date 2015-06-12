<?php 
	session_start(); 
   include(dirname(__FILE__).'/ValidateCode.php');  
   $_vc = new ValidateCode(); 
   $_vc->doimg();
   $_SESSION['validate_code'] = $_vc->getCode();
?>