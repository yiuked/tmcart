{if isset($total) && $total>0}
  <div class="h_title" style="margin-top:20px;">YOUR SEARCH RESULTS FOR: {$query} </div>
  {include file="$tpl_dir./block/product_list.tpl"}
{else}
	<h2 class="tc-standard">Sorry, your search for "{$query}" produced no results.</h2>
	<div class="box-style">
	  <div class="bd">
	   <div> Would you like to search again using a different spelling or fewer search terms? </div>
		<ul class="spacer-list no txt-14">
		  <li>Looking for the hottest styles? <a href="{$link->getPage('SaleView')}" class="all no"><strong>This way for inspiration...</strong></a> </li>
		  <li>Already added items to your favourites? <a href="{$link->getPage('WishView')}" class="all no"><strong>See them here!</strong></a> </li>
		</ul>
	  </div>
	</div>
{/if}
