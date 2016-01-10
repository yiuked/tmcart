<div id="main_columns_two">
	<h3 class="subheading"><span class="whitebg">Contact Us</span></h3>
	<span class="formLabel">
		   <strong> We're here to help </strong>
	</span>
    <p class="comment-notes">Your satisfaction is important to us. Use the links below to email us your questions about online orders, returns & exchanges and more. </p>
	<br>
	<span class="formLabel"><strong> Order Questions </strong></span>
	<div class="show_url">
		<a href="{$link->getPage('MyFeedbackView')}">How can I review my order?</a><br>
		<a href="{$link->getPage('MyOrdersView')}">How can I track my package?</a><br>
	</div>
	<br><br>
	<span class="formLabel">
		   <strong>Other order questions</strong>
	</span>
  <div id="respond" class="respond" style="background:none; margin:0; padding:0;">
    <form id="commentform" method="post" action="{$root_dir}contact.html">
	  {include file="$tpl_dir./block/errors.tpl"}
	  {if $success}<div class="success">{$success}</div>{/if}
	  {if !$logged}
      <p class="comment-form-author">
        <label for="author">Name:</label>
        <input type="text" aria-required="true" size="30" value="{if !$success && isset($smarty.post.name)}$smarty.post.name{/if}" name="name" id="name">
      </p>
      <p class="comment-form-email">
        <label for="email">E-mail:</label>
        <input type="text" aria-required="true" size="30" value="{if !$success && isset($smarty.post.email)}{$smarty.post.email}{/if}" name="email" id="email">
      </p>
	  {/if}
      <p class="comment-form-url">
        <label for="url">Title:</label>
        <input type="text" size="30" value="{if !$success && isset($smarty.post.subject)}{$smarty.post.subject}{/if}" name="subject" id="subject">
      </p>
      <p class="comment-form-comment">
        <label for="comment">Enter your comments:</label>
        <textarea aria-required="true" rows="5" cols="45" name="content" id="content">{if !$success && isset($smarty.post.content)}{$smarty.post.content}{/if}</textarea>
      </p>
	  <p class="comment-form-validate_code">
        <label for="url">Enter Confirmation code:</label>
        <input type="text" size="8" value="" name="validate_code" id="validate_code">
		<img src="{$tools_dir}code/img.php" onclick="javascript:this.src='{$tools_dir}code/img.php?tm='+Math.random();" />
      </p>
      <p class="form-allowed-tags">You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>&lt;a href="" title=""&gt; &lt;abbr title=""&gt; &lt;acronym title=""&gt; &lt;b&gt; &lt;blockquote cite=""&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=""&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=""&gt; &lt;strike&gt; &lt;strong&gt; </code></p>
      <p class="form-submit">
		<input type="submit" value="Send My Message" name="contactUs" id="contactUs" class="button pink">
      </p>
    </form>
  </div>
  <!-- #respond -->
</div>