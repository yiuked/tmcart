标签：{foreach from=$node item=tag name=tag}
<a href="{$tag.link}" title="{$tag.name}">{$tag.name}</a>{if !$smarty.foreach.tag.last},{/if}
{/foreach}