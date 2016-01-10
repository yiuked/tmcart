<section class="actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Style</span></a></h3>
  <ul class="list-shopstyle">
  	{foreach from=$shopByStyle item=style name=blockStyle}
    <li class="shopstyle-bloc"><a title="{$style.name}" href="{$style.link}">{$style.name}</a></li>
	{/foreach}
  </ul>
</section>
