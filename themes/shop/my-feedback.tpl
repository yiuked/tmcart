<div id="main_columns_two" class="custom">
	{include file="$tpl_dir./block/errors.tpl"}
	{if $success}
	<div class="success">Your feedback has been submitted, but you feedback information may not be displayed right away!</div>
	{/if}
	<h2>My Feedback</h2>
	<p style="padding-top:5px;margin:0px">  
		<span class="signatureRequired">PLEASE NOTE: </span> Only pay successful products allowed to feedback. 
	</p>
	{if $products|count>0}
	<div class="feedback-form">
	<form action="" method="post" name="form1">
		<div class="form-row form-rating-row">
			<label>Rating</label>
			<input type="radio" name="rating" value="1" {if isset($smarty.post.rating) && $smarty.post.rating==1}checked{/if}>
			<div class="feedback-star star-block">
				<ul class="rate txt-16">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
				<ul class="rate txt-16 active" style="width:20%">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
			</div>
			<input type="radio" name="rating" value="2" {if isset($smarty.post.rating) && $smarty.post.rating==2}checked{/if}>
			<div class="feedback-star star-block">
				<ul class="rate txt-16">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
				<ul class="rate txt-16 active" style="width:40%">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
			</div>
			<input type="radio" name="rating" value="3" {if isset($smarty.post.rating) && $smarty.post.rating==3}checked{/if}>
			<div class="feedback-star star-block">
				<ul class="rate txt-16">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
				<ul class="rate txt-16 active" style="width:60%">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
			</div>
			<input type="radio" name="rating" value="4" {if isset($smarty.post.rating) && $smarty.post.rating==4}checked{/if}>
			<div class="feedback-star star-block">
				<ul class="rate txt-16">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
				<ul class="rate txt-16 active" style="width:80%">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
			</div>
			<input type="radio" name="rating" value="5" {if isset($smarty.post.rating) && $smarty.post.rating==5}checked{/if}>
			<div class="feedback-star star-block">
				<ul class="rate txt-16">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
				<ul class="rate txt-16 active" style="width:100%">
				   <li><span class="icon-star"><span>1</span></span></li>
				   <li><span class="icon-star"><span>2</span></span></li>
				   <li><span class="icon-star"><span>3</span></span></li>
				   <li><span class="icon-star"><span>4</span></span></li>
				   <li><span class="icon-star"><span>5</span></span></li>
				</ul>
			</div>
		</div>
		<div class="form-row form-select-row">
			<label>Select Product</label>
			<select class="form-select" name="data">
			{foreach from=$products item=product name=product}
				<option value="{$product.data}" {if isset($smarty.post.data) && $smarty.post.data==$product.data}selected="selected"{/if}>{$product.name}</option>
			{/foreach}
			</select>
		</div>
		<div class="form-row form-textarea-row">
			<label>Feedback</label>
			<textarea name="feedback" cols="100" id="feedback" rows="5">{if isset($smarty.post.feedback)}{$smarty.post.feedback}{/if}</textarea>
		</div>
		<div class="form-row form-submit-row">
			<input type="submit" class="button big pink" value="Submit" name="submit" onclick="return formCheck()" >
		</div>
		</form>
	</div>
	{else}
	<p>No product need feedback</p>
	{/if}
</div>
<script>
{literal}
function formCheck(){
	var ratingNumber = parseInt($('input:radio:checked').val());
	if(isNaN(ratingNumber) || ratingNumber==0){
		alert('Pls rating!');
		return false;
	}
	return true;
}
{/literal}
</script>