<section class="actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	{foreach from=$colors item=color name=shopByColor}
    <li class="shopcolor-bloc"><a title="{$color.name}" href="{$color.link}"><span style="background:{$color.code}">{$color.name}</span></a></li>
	{/foreach}
  </ul>
</section>
