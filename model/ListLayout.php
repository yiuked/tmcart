<?php
	class ListLayout
	{
		private $_column;
		private $_html;
		private $_entity;
		private $_entityname;
		public  $add = true;
		
		public function __constract($entity,$name='实体')
		{
			$this->_entity 		= $entity;
			$this->_entityname  = $name;
		}
		
		public function setColumn($key,$name)
		{
			$this->_column[$key]=$name;
			return $this;
		}
		
		public function setHead()
		{
			$this->_html .='
				<script type="text/javascript" src="'._TM_JS_URL.'/jquery/jquery.tablednd_0_5.js"></script>
				<script src="'._TM_JS_URL.'/admin/dnd.js" type="text/javascript"></script>';
			
			$this->_html .='
				<div class="path_bar">
					<div class="path_title">
						<h3> 
							<span style="font-weight: normal;" id="current_obj">
							<span class="breadcrumb item-1 ">'.$this->_entityname.'</span> 
						</h3>';
			
			if($this->add)	
				$this->_html .='		
						<div class="cc_button">
							<ul>
							<li><a title="添加'.$this->_entityname.'" href="admin.php?rule='.$this->_entity.'&display=add" class="toolbar_btn" id="add_'.$this->_entity.'">
									<span class="process-icon-new "></span>
									<div>添加'.$this->_entityname.'</div>
								</a></li>
							</ul>
						</div>';
						
			$this->_html .='			
					</div>
				</div>';
			
		}
	}
?>