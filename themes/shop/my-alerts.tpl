<div class="container">
	<div class="row">
		<div class="col-md-2">
			{$DISPLAY_LEFT}
		</div>
		<div class="col-md-10">
			<div class="list-style">
				<ul>
				{if $alerts}
					{foreach from=$alerts item=alert name=alert}
					<li class="alert-item" {if !$alert.is_read}data-id="{$alert.id_alert}"{/if} onclick="location.href='?id_alert={$alert.id_alert}'">
						{if !$alert.is_read}<strong>{$alert.content}</strong>{else}{$alert.content}{/if}<span class="floatr">{$alert.add_date}</span>
					</li>
					{/foreach}
				{/if}
				</ul>
			</div>
		</div>
	</div>
</div>