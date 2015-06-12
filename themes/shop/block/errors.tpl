{if isset($errors) && $errors}
	<div class="error">
		ERROR    
		<ol>
		{foreach from=$errors key=k item=error}
			<li>{$error}</li>
		{/foreach}
		</ol>
	</div>
{/if}