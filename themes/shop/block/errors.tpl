{if isset($errors) && $errors}
	<div class="alert alert-danger" role="alert">
		错误
		<ol>
		{foreach from=$errors key=k item=error}
			<li>{$k}-{$error}</li>
		{/foreach}
		</ol>
	</div>
{/if}