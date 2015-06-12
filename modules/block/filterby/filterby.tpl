<div class="product-list-filter">
<div class="header off">
	<h2 {if count($filter)}data-count="{count($filter)}"{/if}><strong>Filter by</strong></h2>
	<ul class="filter-resume">
		{if count($filter)}
		{if isset($filter.color)}
		<li><strong>Color: {$filter.color.name}</strong><a href="?" class="icon-cancel-2"></a></li>
		{/if}
		<li class="resetFilter"><a href="?"><strong>Delete selection</strong><i class="icon-cancel-2"></i></a></li>
		{/if}
	</ul>
</div>
{if $styles}
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Style</span></a></h3>
  <ul class="filter">
  	{foreach from=$styles item=style name=styleFilter}
    <li class="shopstyle-bloc"><a title="{$style.name}" href="{$style.link}{$ags}{if isset($style.color)}id_color={$style.color.path}{/if}">
		<i class="icon-radio{if isset($id_parent_path)&&strpos($id_parent_path,$style.id_category)}-checked{/if}"></i><span>{$style.name}</span></a>
	</li>
	{/foreach}
  </ul>
</div>
{/if}

{if $view_name=='index'}
{if $colors}
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	{foreach from=$colors item=color name=colorFilter}
    <li class="shopcolor-bloc">
		<a title="{$color.name}" href="{$color.link}" {if isset($filter.color)&&in_array($color.id_color,$filter.color.id)}class="active"{/if}>
		<span style="background:{$color.code}">{$color.name}</span></a>
	</li>
	{/foreach}
  </ul>
</div>
{/if}
{else}
{if $colors}
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	{foreach from=$colors item=color name=colorFilter}
    <li class="shopcolor-bloc">
		<a title="{$color.name}" href="?id_color={if isset($filter.color)}{$filter.color.path}{/if}{$color.id_color}" {if isset($filter.color)&&in_array($color.id_color,$filter.color.id)}class="active"{/if}>
		<span style="background:{$color.code}">{$color.name}</span></a>
	</li>
	{/foreach}
  </ul>
</div>
{/if}
{/if}
</div>
