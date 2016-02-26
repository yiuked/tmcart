<script>
function navCartPrev(obj)
{
	var nextBtn = obj.parent();
	var bdUl	= nextBtn.next().find("ul");
	var bdUltop	= parseInt(bdUl.css("top"));
	var newTop	= "0px";
	if(bdUltop>-1800){
		newTop	= (bdUltop-300)+'px';
	}
	bdUl.animate({top:newTop});
}
</script>
<div id="color_block_left" class="block">
  <h4>Product reviews</h4>
  <div class="block_content">
  <a class="vert-car-nav prev"><span onclick="navCartPrev($(this))"><img src="{$img_dir}np.png"></span></a>
  <div class="bd">
		<ul class="vertical-carousel" style="top: 0px;">
	  	{foreach from=$feedbacks item=feedback name=feedbackBlock}
			<li>
				<div class="feedback_content">{$feedback.feedback}</div>
				<div class="rate-history">
					<span class="rate-title">Rating:</span>
					<span class="star star-s" title="Star Rating: {$feedback.rating} out of 5"> 
						<span class="rate-percent" style="width: {$feedback.rating/5*100}%;"></span>
					</span>
				</div>
				<p class="review-name">{$feedback.name|truncate:50:"..."}<a href="{$feedback.link}" title="{$feedback.name}"><strong>show more</strong></a></p>
			</li>
		{/foreach}
		</ul>
  </div>
  </div>
</div>
<br/>
