{foreach from=$posts item=post name=post}
<div class="posts">
  <article id="post-{$post.id_cms}" class="post">
    <div class="meta">{$post.add_date} {include file="$tpl_dir./block/cms_tag.tpl" node=$post.tags}</div>
    <div class="commentcount"> <a title="{$post.title}" href="{$post.link}#comments">1 评论</a></div>
    <h2 class="posts_title"><a href="{$post.link}">{$post.title}</a></h2>
    <div class="entry">{$post.content}</div>
    <footer class="metabottom">
	
	</footer>
    <div class="nr_clear"></div>
  </article>
</div>
{/foreach}