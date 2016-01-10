<div class="row product-pagination">
	<div class="col-md-5">
		<form action="{$this_url}" method="POST">
			<div class="itemCountControls">
				{if isset($query)}
				<input type="hidden" name="s" value="{$query}" />
				{/if}
				商品: <strong>{($p-1)*$n} - {if $currenN>$total}{$total}{else}{$currenN}{/if}</strong> 共 <strong>{$total}</strong> 件

				每页显示
				<select onchange="this.form.submit()" name="resultSize" class="form-control change-page-number">
					{foreach from=$n_list name=per item=per}
					<option {if $n==$per}selected="selected"{/if} value="{$per}"> {$per} 件</option>
					{/foreach}
				</select>
				商品
			</div>
		</form>
	</div>

	{*总共显示多少页*}
	{assign var="showPage" value="5"}
	{*当前页前显示多少页*}
	{assign var="pageBefor" value="3"}
	<div class="col-md-4">

		<ul class="pagination">
		{if $p != 1}
		<li><a class="control prev" href="{$link->goPage($this_url, $p - 1)}">上一页</a></li>
		{else}
		<li><span class="control ui-pagination-prev ui-pagination-disabled">上一页</span></li>
		{/if}

		{if $pages_nb<$showPage}
			{section name=pagination start=1 loop=$pages_nb+1 step=1}
				{if $p == $smarty.section.pagination.index}
				<li class="active"><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{else}
				<li><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{/if}
			{/section}
		{elseif $p<=($pageBefor+1)}
			{section name=pagination start=1 loop=$showPage+1 step=1}
				{if $p == $smarty.section.pagination.index}
				<li class="active"><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{else}
				<li><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{/if}
			{/section}
		{elseif $pages_nb-$p<=$pageBefor}
			{section name = pagination start = $pages_nb - $showPage + 1 loop = $pages_nb + 1 step=1}
				{if $p == $smarty.section.pagination.index}
				<li class="active"><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{else}
				<li><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{/if}
			{/section}
		{else}
			{section name=pagination start=$p-$pageBefor loop=$p+$showPage-$pageBefor step=1}
				{if $p == $smarty.section.pagination.index}
				<li class="active"><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{else}
				<li><a class="control pageNum" href="{$link->goPage($this_url,$smarty.section.pagination.index)}">{$smarty.section.pagination.index}</a></li>
				{/if}
			{/section}
		{/if}

		{if $pages_nb > 1 AND $p != $pages_nb}
			<li><a class="control next" href="{$link->goPage($this_url,$p+1)}">下一页</a></li>
		{else}
			<li><span class="control ui-pagination-next ui-pagination-disabled">下一页</span></li>
		{/if}
		</ul>
	</div>
	<div class="col-md-3">
		共 <strong>{$pages_nb}</strong> 页
		到第 <input type="text" value="{$pages_nb}" name="pagigation-nb" id="pagigation-nb" class="form-control"> 页
		<input type="button" value="确定" class="btn btn-default" id="pagination-goto-submit">
	</div>
</div>