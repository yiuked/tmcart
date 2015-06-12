<script language="javascript">
{literal}
$(function(){
    $('.dept_select').chosen({disable_search_threshold: 10});
});
{/literal}
</script>
<div class="itemsShown">Items: <strong>{($p-1)*$n} - {if $currenN>$total}{$total}{else}{$currenN}{/if}</strong> of <strong>{$total}</strong></div>
<form action="{$this_url}" method="GET">
	<div class="itemCountControls">
		<span class="label">VIEW:</span>
		{if isset($query)}
		<input type="hidden" name="s" value="{$query}" />
		{/if}
		<select onchange="this.form.submit()" name="resultSize" class="dept_select" style="width:100px;text-align:left;">
			{foreach from=$n_list name=per item=per}
			<option {if $n==$per}selected="selected"{/if} value="{$per}">{$per} items</option> 
			{/foreach}
		</select>
	</div>
</form>
<form action="{$this_url}" method="GET">
	<div class="sortByControls">
		<span class="label">SORT BY:</span>
		{if isset($query)}
		<input type="hidden" name="s" value="{$query}" />
		{/if}
		<select onchange="this.form.submit()" name="sort" class="dept_select" style="width:150px;text-align:left;">
		  <option value="newest" {if $sort=='newest'}selected="selected"{/if}>Newest</option>
		  <option value="orders" {if $sort=='orders'}selected="selected"{/if}>Orders</option>
		  <option value="rental_price_desc" {if $sort=='rental_price_desc'}selected="selected"{/if}>Price: high to low</option>
		  <option value="rental_price_asc" {if $sort=='rental_price_asc'}selected="selected"{/if}>Price: low to high</option>
		</select>
	</div>
</form>
{*总共显示多少页*}
{assign var="showPage" value="5"}
{*当前页前显示多少页*}
{assign var="pageBefor" value="3"}
<div class="browsePageControls">
	<span class="label">PAGE:</span>
	{if $p != 1}
	<a class="control prev" href="{$link->goPage($this_url,$p-1)}">&nbsp; &nbsp;</a>
	{else}
	<span class="control ui-pagination-prev ui-pagination-disabled">&nbsp; &nbsp;</span>
	{/if}
	{if $pages_nb<$showPage}
		{section name=pagination start=1 loop=$pages_nb+1 step=1}
			{if $p == $smarty.section.pagination.index}
			<a class="control pageNum selected" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{else}
			<a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{/if}
		{/section}
	{elseif $p<=($pageBefor+1)}
		{section name=pagination start=1 loop=$showPage+1 step=1}
			{if $p == $smarty.section.pagination.index}
			<a class="control pageNum selected" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{else}
			<a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{/if}
		{/section}
	{elseif $pages_nb-$p<=$pageBefor}
		{section name=pagination start=$pages_nb-$showPage+1 loop=$pages_nb+1 step=1}
			{if $p == $smarty.section.pagination.index}
			<a class="control pageNum selected" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{else}
			<a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{/if}
		{/section}
	{else}
		{section name=pagination start=$p-$pageBefor loop=$p+$showPage-$pageBefor step=1}
			{if $p == $smarty.section.pagination.index}
			<a class="control pageNum selected" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{else}
			<a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a>
			{/if}
		{/section}	
	{/if}

	{if $pages_nb > 1 AND $p != $pages_nb}
	<a class="control next" href="{$link->goPage($this_url,$p+1)}">&nbsp; &nbsp;</a>
	{else}
	<span class="control ui-pagination-next ui-pagination-disabled">&nbsp; &nbsp;</span>
	{/if}
	
	<div class="ui-pagination-goto">
		<input type="hidden" id="max-page-nb" class="max-page-nb" value="{$pages_nb}" />
		<label for="" class="ui-label">
			Go to Page
			<input type="text" class="ui-textfield ui-textfield-system" maxlength="3" id="pagination-bottom-input">
		</label>
		<input type="button" value="Go" id="pagination-bottom-goto">
	</div>
</div>