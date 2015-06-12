<li id="comment-{$node.id_cms_comment}" class="comment">
  <div class="comment-body" id="div-comment-{$node.id_cms_comment}">
	<div class="comment-author vcard"> <img height="32" width="32" class="avatar avatar-32 photo" src="http://www.geekinheels.com/wp-content/plugins/fv-gravatar-cache/images/325ee22e3f31ae0ebe496c25c322fc8f" alt=""> <cite class="fn"><a class="url" rel="external nofollow" href="{$comment.website}">{$node.name}</a></cite><span class="says">:</span> </div>
	<div class="comment-meta commentmetadata"><a href="{Tools::getLink($entity->rewrite)}#comment-{$node.id_cms_comment}">回复于：{$node.add_date}</a> </div>
	<p>{$node.comment}</p>
	<div class="reply"> <a href="{Tools::getLink($entity->rewrite)}#respond" onclick="changeKeepID({$node.id_cms_comment})" class="comment-reply-link">回复</a> </div>
  </div>
  {if $node.children|@count > 0}
		<ul>
		{foreach from=$node.children item=child name=commentTree}
			{include file="$tpl_dir./block/cms_comment_tree.tpl" node=$child}
		{/foreach}
		</ul>
  {/if}
</li>