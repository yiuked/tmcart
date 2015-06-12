<?php
class FeedView extends View
{
		public $use_tpl = false;
		
		public function displayMain()
		{
			  $postFeed = new FeedWriter(RSS2);
			  $postFeed->setTitle(Configuration::get('TM_SHOP_NAME'));
			  $postFeed->setLink(Configuration::get('TM_SHOP_URL'));
			  $postFeed->setDescription('This is test of creating a RSS 2.0 feed Universal Feed Writer');
			 
			  $postFeed->setImage('Testing the RSS writer class','http://www.ajaxray.com/projects/rss','http://www.rightbrainsolution.com/images/logo.gif');
			 	
				$posts = CMSHelper::getNewCMS(50);
				
 				foreach($posts as $row){
					$newItem = $postFeed->createNewItem();
					$newItem->setTitle($row['title']);
					$newItem->setLink($row['link']);
					$newItem->setDate($row['add_date']);
					$newItem->setDescription($row['content']);
					$postFeed->addItem($newItem);
				}
			  $postFeed->genarateFeed();
		}
}
?>