{if $entity}
<div id="main_columns_two">
  <article id="post-{$entity->id}" class="post">
{if !$entity->is_page}
    <div class="meta">{$entity->add_date} {include file="$tpl_dir./block/cms_tag.tpl" node=$tags}</div>
    <div class="commentcount"> <a title="{$entity->title}" href="#comments">我要评论({$comments_nb})</a></div>
{/if}
    <h2><span>{$entity->title}</span></h2>
    <div class="entry">{$entity->content}</div>
    <footer class="metabottom">
	
	</footer>
    <div class="nr_clear"></div>
  </article>
</div>
{/if}
{if !$entity->is_page}
{include file="$tpl_dir./block/cms_comment.tpl"}
{/if}