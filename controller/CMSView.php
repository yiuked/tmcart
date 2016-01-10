<?php
class CMSView extends View
{
		public function displayMain()
		{
			global $smarty;
			parent::displayMain();
			
			if(Tools::isSubmit('submit'))
				$this->postComment();
			
			$comments = $this->entity->getComments();
			$smarty->assign(array(
					'tags'   => CMS::getCMSTags($this->entity->id),
					'errors' => $this->_errors,
					'success' => $this->_success,
					'comments' => $comments,
					'comments_nb' => count($comments),
					'entity' => $this->entity,
			));
			return $smarty->fetch('cms.tpl');
		}

		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('cmsblock')),
			));
			return $smarty->fetch('block/left_columns.tpl');
		}

		public function postComment()
		{	
			global $smarty;
			session_start();
			if($_SESSION['validate_code']==strtolower(Tools::getRequest('validate_code'))){
				$comment = new CMSComment();
				$comment->copyFromPost();
				if($comment->add()){
					$this->_success = '添加评论成功，请等待管理员审核哟！';
				}else{
					$this->_errors = $comment->_errors;
				}
			}else{
				$this->_errors[] = '验证码错误！';
			}
		}
}
?>