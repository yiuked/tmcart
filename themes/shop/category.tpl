<div class="container">
    <div class="filters">
        <div class="row filter-heading">
            <div class="col-md-12" >商品筛选</div>
        </div>
        {if isset($filters['brand']) && $filters['brand']}
        <div class="row filter-line">
            <div class="col-md-1 title">品牌</div>
            <div class="col-md-10 value">
                <ul class="inline">
                    {foreach from=$filters['brand'] item=brand}
                    <li>{$brand.name}({$brand.filter_num})</li>
                    {/foreach}
                </ul>
            </div>
            <div class="col-md-1 extra"></div>
        </div>
        {/if}
        {if isset($filters['categories']) && $filters['categories']}
            <div class="row filter-line">
                <div class="col-md-1 title">分类</div>
                <div class="col-md-10 value">
                    <ul class="inline">
                        {foreach from=$filters['categories'] item=category}
                            <li>{$category.name}({$category.filter_num})</li>
                        {/foreach}
                    </ul>
                </div>
                <div class="col-md-1 extra"></div>
            </div>
        {/if}
        {if isset($filters['feature']) && $filters['feature']}
            {foreach from=$filters['feature'] item=feature}
            <div class="row filter-line">
                <div class="col-md-1 title">{$feature.name}</div>
                <div class="col-md-10 value">
                    <ul class="inline">
                        {foreach from=$feature.values item=value}
                            <li>{$value.name}({$value.filter_num})</li>
                        {/foreach}
                    </ul>
                </div>
                <div class="col-md-1 extra"></div>
            </div>
            {/foreach}
        {/if}
        {if isset($filters['attribute']) && $filters['attribute']}
            {foreach from=$filters['attribute'] item=group}
                <div class="row filter-line">
                    <div class="col-md-1 title">{$group.name}</div>
                    <div class="col-md-10 value">
                        <ul class="inline">
                            {foreach from=$group.values item=value}
                                <li>{$value.name}({$value.filter_num})</li>
                            {/foreach}
                        </ul>
                    </div>
                    <div class="col-md-1 extra"></div>
                </div>
            {/foreach}
        {/if}
    </div>
    <div class="row product-extra-bar">
        <div class="col-md-3">
            <div class="btn-group btn-group-sm" role="group">
                <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default">综合</a>
                <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default">新品</a>
                <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default">销量</a>
                <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default">评论</a>
                <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default">价格</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-daterange input-group">
                <span class="input-group-addon">价格</span>
                <input type="text" class="input-sm form-control" name="start_price">
                <span class="input-group-addon">到</span>
                <input type="text" class="input-sm form-control" name="end_price">
            </div>
        </div>
        <div class="col-md-6 text-right">
            {$p}/{$pages_nb}
            <div class="btn-group btn-group-sm" role="group">
                {if $p != 1}
                    <a href="{$link->goPage($this_url, $p - 1)}" class="btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-menu-left"></span></a>
                {else}
                    <button type="button" class="btn btn-default" disabled="disabled"><span aria-hidden="true" class="glyphicon glyphicon-menu-left"></span></button>
                {/if}
                {if $pages_nb > 1 AND $p != $pages_nb}
                    <a href="{$link->goPage($this_url,$p+1)}" class="btn btn-default"><span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></a>
                {else}
                    <button type="button" class="btn btn-default" disabled="disabled"><span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></button>
                {/if}

            </div>
        </div>
    </div>


{include file="$tpl_dir./block/product_list.tpl"}
</div>