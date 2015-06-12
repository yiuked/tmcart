<?php
class Helper
{
	public static $translationsKeysForAdminCategorieTree = array(
		 'Home', 'selected', 'selecteds', 'Collapse All', 'Expand All', 'Check All', 'Uncheck All'
	);
	
	/**
	 *
	 * @param type $trads values of translations keys
	 *					For the moment, translation are not automatic
	 * @param type $selected_cat array of selected categories
	 *					Format
	 *						Array
							(
								 [0] => 1
								 [1] => 2
	 						)
	 *					OR
							Array
							(
								 [1] => Array
									  (
											[id_category] => 1
											[name] => Home page
											[link_rewrite] => home
									  )
							)
	 * @param type $input_name name of input
	 * @return string 
	 */
	public static function renderAdminCategorieTree($trads, $selected_cat = array(), $input_name = 'categoryBox', $use_radio = false,$type)
	{
		if (!$use_radio)
			$input_name = $input_name.'[]';
		
		$html = '
		<script src="../js/jquery/treeview/jquery.treeview.js" type="text/javascript"></script>
		<script src="../js/jquery/treeview/jquery.treeview.async.js" type="text/javascript"></script>
		<script src="../js/jquery/treeview/jquery.treeview.edit.js" type="text/javascript"></script>
		<script src="../js/admin/categories-tree.js" type="text/javascript"></script>
		<script type="text/javascript">
			var inputName = "'.$input_name.'";
		';

		$html .= 'var treeType = "'.$type.'";';
		if (sizeof($selected_cat) > 0)
		{
			if (isset($selected_cat[0]))
				$html .= 'var selectedCat = "'.implode(',', $selected_cat).'"';
			else
				$html .= 'var selectedCat = "'.implode(',', array_keys($selected_cat)).'"';
		} else {
			$html .= 'var selectedCat = ""';
		}
		$html .= '
			var selectedLabel = \''.$trads['selected'].'\';
			var home = \''.$trads['Home'].'\';
			var use_radio = '.(int)$use_radio.';
		</script>
		<link type="text/css" rel="stylesheet" href="../js/jquery/treeview/jquery.treeview.css" />
		';
		
		$html .= '
		<div style="background-color:#F4E6C9; width:99%;padding:5px 0 5px 5px;">
			<a href="#" id="collapse_all" >'.$trads['Collapse All'].'</a>
			 - <a href="#" id="expand_all" >'.$trads['Expand All'].'</a>
			'.(!$use_radio ? '
			 - <a href="#" id="check_all" >'.$trads['Check All'].'</a>
			 - <a href="#" id="uncheck_all" >'.$trads['Uncheck All'].'</a>
			' : '').'
		</div>
		';
		
		$home_is_selected = false;
		foreach($selected_cat AS $cat)
		{
			if (is_array($cat))
			{
				if  ($cat['id_category'] != 1)
					$html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat['id_category'].'" >';
				else
					$home_is_selected = true;
			}
			else
			{
				if  ($cat != 1)
					$html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat.'" >';
				else
					$home_is_selected = true;
			}
		}
		$html .= '
			<ul id="categories-treeview" class="filetree">
				<li id="1" class="hasChildren">
					<span class="folder"> <input type="'.(!$use_radio ? 'checkbox' : 'radio').'" name="'.$input_name.'" value="1" '.($home_is_selected ? 'checked' : '').' onclick="clickOnCategoryBox($(this));" /> '.$trads['Home'].'</span>
					<ul>
						<li><span class="placeholder">&nbsp;</span></li>	
				  </ul>
				</li>
			</ul>';
		return $html;
	}
	
	public static function renderAdminDoubleTree($trads, $selected_cat = array(), $input_name = 'categoryBox', $use_radio = false,$type)
	{
		if (!$use_radio)
			$input_name = $input_name.'[]';
		
		$html = '
		<script type="text/javascript">
			var inputName = "'.$input_name.'";
		';

		$html .= 'var treeType = "'.$type.'";';
		if (sizeof($selected_cat) > 0)
		{
			if (isset($selected_cat[0]))
				$html .= 'var selectedCat = "'.implode(',', $selected_cat).'"';
			else
				$html .= 'var selectedCat = "'.implode(',', array_keys($selected_cat)).'"';
		} else {
			$html .= 'var selectedCat = ""';
		}
		$html .= '
			var selectedLabel = \''.$trads['selected'].'\';
			var home = \''.$trads['Home'].'\';
			var use_radio = '.(int)$use_radio.';
		</script>';
		
		$html .= '
		<div style="background-color:#F4E6C9; width:99%;padding:5px 0 5px 5px;">
			<a href="#" id="collapse_all" >'.$trads['Collapse All'].'</a>
			 - <a href="#" id="expand_all" >'.$trads['Expand All'].'</a>
			'.(!$use_radio ? '
			 - <a href="#" id="check_all" >'.$trads['Check All'].'</a>
			 - <a href="#" id="uncheck_all" >'.$trads['Uncheck All'].'</a>
			' : '').'
		</div>
		';
		
		$home_is_selected = false;
		foreach($selected_cat AS $cat)
		{
			if (is_array($cat))
			{
				if  ($cat['id_category'] != 1)
					$html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat['id_category'].'" >';
				else
					$home_is_selected = true;
			}
			else
			{
				if  ($cat != 1)
					$html .= '<input type="hidden" name="'.$input_name.'" value="'.$cat.'" >';
				else
					$home_is_selected = true;
			}
		}
		$html .= '
			<ul id="categories-treeview" class="filetree">
				<li id="1" class="hasChildren">
					<span class="folder"> <input type="'.(!$use_radio ? 'checkbox' : 'radio').'" name="'.$input_name.'" value="1" '.($home_is_selected ? 'checked' : '').' onclick="clickOnCategoryBox($(this));" /> '.$trads['Home'].'</span>
					<ul>
						<li><span class="placeholder">&nbsp;</span></li>	
				  </ul>
				</li>
			</ul>';
		return $html;
	}
	
	public static function renderAdminPagaNation($total,$pagenum,$p,$boutton='page')
	{
		global $_tmconfig;
		$html 	= '<input type="hidden" value="'.$p.'" name="'.$boutton.'" id="'.$boutton.'">';
		
		$top 	= ceil($total/$pagenum);
		
		if($top==1){
			$html .= 'Page<b>1</b> / 1';
		}elseif($top>1 and $p>1 and $p<=$top){
			$html .= '
				<input type="image" onclick="$(\'#'.$boutton.'\').val(1)" src="'.$_tmconfig['ico_dir'].'list-prev2.gif">&nbsp;
				<input type="image" onclick="$(\'#'.$boutton.'\').val('.($p-1).')" src="'.$_tmconfig['ico_dir'].'list-prev.gif">';
		}
		
		if($top>1)
			$html .= 'Page<b>'.$p.'</b> / '.$top;
		
		if($top>1 and $p>=1 and $p<$top){
			$html .= '
				<input type="image" onclick="$(\'#'.$boutton.'\').val('.($p+1).')" src="'.$_tmconfig['ico_dir'].'list-next.gif">&nbsp;
				<input type="image" onclick="$(\'#'.$boutton.'\').val('.($top).')" src="'.$_tmconfig['ico_dir'].'list-next2.gif">';
		}
		return $html;
	}
}
