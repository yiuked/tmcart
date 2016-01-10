<div id="categories_block_left" class="block">
  <h4>Categories</h4>
  <div class="block_content">
		<ul class="level1_menu">
	  	{foreach from=$blockCategTree.children item=child name=blockCategTree}
			<li class="level1_items{if isset($id_parent_path)&&strpos($id_parent_path,$child.id)} selected{/if}">
				<span class="level1-name">{$child.name}</span>
				{if $child.children}
					<div class="level2_box">
						<ul class="level2_menu">
							{foreach from=$child.children item=node name=childNode}
								<li class="level2_items{if isset($id_parent_path)&&strpos($id_parent_path,$node.id)} selected{/if}">
									<a class="level2_a" title="{$node.name}" href="{$node.link}">{$node.name}</a>{if count($node.children)>0}<span class="node-icon"></span>{/if}
									{if $node.children}
										<div class="level3_box">
											<ul class="level3_menu">
												{foreach from=$node.children item=threeNode name=threeNode}
													<li class="level3_items{if isset($id_parent_path)&&strpos($id_parent_path,$threeNode.id)} selected{/if}">
														<a class="level3_a" title="{$threeNode.name}" href="{$threeNode.link}">{$threeNode.name}</a>
													</li>
												{/foreach}
											</ul>
										</div>
									{/if}
								</li>
							{/foreach}
						</ul>
					</div>
				{/if}
			</li>
		{/foreach}
		</ul>
  </div>
</div>
<script>
{literal}
$(document).ready(function(){
	$(".level1-name").click(function(){
		if($(this).parent().hasClass("selected")){
			$(this).parent().removeClass("selected")
		}else{
			$(".level1-name").parent().removeClass("selected");
			$(this).parent().addClass("selected")
		}
	})
	$(".node-icon").click(function(){
		if($(this).parent().hasClass("selected")){
			$(this).parent(".level2_items").removeClass("selected");
		}else{
			$(".node-icon").parent(".level2_items").removeClass("selected");
			$(this).parent().addClass("selected")
		}
		event.stopPropagation();
	})
})
{/literal}
</script>
