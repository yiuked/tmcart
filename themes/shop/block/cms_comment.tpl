<div id="comments">
  <h3 class="subheading"><span class="whitebg">共 {$comments_nb} 条评论</span></h3>
  <div id="comments_nav"> </div>
  <ol class="commentlist">
  {foreach from=$comments item=comment name=comment}
		{include file="$tpl_dir./block/cms_comment_tree.tpl" node=$comment}
  {/foreach}
  </ol>
  <div id="comments_nav"> </div>
  <div id="respond" class="respond">
    <h3 id="reply-title">到此一游么，留点什么吗？</h3>
    <form id="commentform" method="post" action="{$this_url}#commentform">
      <p class="comment-notes">放心吧，主人不会公开您的邮箱. <span class="required">*</span>这个，您懂得！</p>
	  {include file="$tpl_dir./block/errors.tpl"}
	  {if $success}<div class="success">{$success}</div>{/if}
      <p class="comment-form-author">
        <label for="author">昵称</label>
        <span class="required">*</span>
        <input type="text" aria-required="true" size="30" value="" name="name" id="name">
      </p>
      <p class="comment-form-email">
        <label for="email">邮箱</label>
        <span class="required">*</span>
        <input type="text" aria-required="true" size="30" value="" name="email" id="email">
      </p>
      <p class="comment-form-url">
        <label for="url">网址</label>
        <input type="text" size="30" value="" name="website" id="website">
      </p>
      <p class="comment-form-comment">
        <label for="comment">评论</label>
        <textarea aria-required="true" rows="8" cols="45" name="comment" id="comment"></textarea>
      </p>
	  <p class="comment-form-validate_code">
        <label for="url">验证码<span class="required">*</span></label>
        <input type="text" size="8" value="" name="validate_code" id="validate_code">
		<img src="{$tools_dir}code/img.php" onclick="javascript:this.src='{$tools_dir}code/img.php?tm='+Math.random();" />
      </p>
      <p class="form-allowed-tags">You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>&lt;a href="" title=""&gt; &lt;abbr title=""&gt; &lt;acronym title=""&gt; &lt;b&gt; &lt;blockquote cite=""&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=""&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=""&gt; &lt;strike&gt; &lt;strong&gt; </code></p>
      <p class="form-submit">
        <input type="submit" value="提交评论" id="submit" name="submit">
		<input type="hidden" value="0" id="id_keep" name="id_keep">
		<input type="hidden" value="{$entity->id}" id="id_cms" name="id_cms">
		<input type="hidden" value="{Tools::getLink($entity->rewrite)}#respond" name="back" id="back" />
      </p>
    </form>
  </div>
  <!-- #respond -->
</div>