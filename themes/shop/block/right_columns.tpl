<div class="textwidget">
	<h4>文章分类</h4>
	<div class="content">
		<ul>
		{foreach from=$cms_cate item=cat name=cat}
			<li><a href="{$cat.link}" title="{$cat.name}">{$cat.name}({$cat.t})</a></li>
		{/foreach}
		</ul>
	</div>
</div>
<div class="textwidget">
	<h4>文章归档</h4>
	<div class="content">
		<ul>
		{foreach from=$date_cms item=d_list name=d_list}
			<li><a href="{$d_list.link}" title="{$d_list.d_date}">{$d_list.d_date}({$d_list.t})</a></li>
		{/foreach}
		</ul>
	</div>
</div>
<div class="textwidget">
	<h4>最新文章</h4>
	<div class="content">
		<ul>
		{foreach from=$new_cms item=newcms name=newcms}
			<li><a href="{$newcms.link}" title="{$newcms.title}">{$newcms.title}</a></li>
		{/foreach}
		</ul>
	</div>
</div>
<div class="textwidget">
	<h4>最新评论</h4>
	<div class="content">
		<ul>
		{foreach from=$last_comments item=comment name=comment}
			<li><a href="{$comment.link}" title="{$comment.comment}">{$comment.comment}</a></li>
		{/foreach}
		</ul>
	</div>
</div>
<div class="textwidget">
	<h4>友情链接</h4>
	<div class="content">
		<ul>
			<li><a href="http://www.prestashop.com/">Prestashop</a></li>
			<li><a href="http://www.opencart.com/">Opencart</a></li>
			<li><a href="http://www.paypal.com/">Paypal</a></li>
			<li><a href="http://www.opencart.com/">支付宝</a></li>
		</ul>
	</div>
</div>