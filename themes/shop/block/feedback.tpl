{if $feedback.state.times>0}
<div id="transction-feedback">
	<div class="feedback-head">
	  <div class="f-rating">
		<dl class="rate-aver">
		  <dd class="star-view star-block">
			<ul class="rate txt-30">
			   <li><span class="icon-star"><span>1</span></span></li>
			   <li><span class="icon-star"><span>2</span></span></li>
			   <li><span class="icon-star"><span>3</span></span></li>
			   <li><span class="icon-star"><span>4</span></span></li>
			   <li><span class="icon-star"><span>5</span></span></li>
			</ul>
			<ul class="rate txt-30 active" style="width:{$feedback.state.total_pt}%">
			   <li><span class="icon-star"><span>1</span></span></li>
			   <li><span class="icon-star"><span>2</span></span></li>
			   <li><span class="icon-star"><span>3</span></span></li>
			   <li><span class="icon-star"><span>4</span></span></li>
			   <li><span class="icon-star"><span>5</span></span></li>
			</ul>
		  </dd>
		  <dt>Average Star Rating:<br>
		  <span class="fwB"><b class="c-org">{$feedback.state.average}</b> out of 5({$feedback.state.times} Ratings)</span></dt>
		</dl>
	  </div>
	  <div class="f-rating-more">
		<div class="legend">Feedback Rating for This Product</div>
		<table class="rate-data">
		  <tbody>
			<tr>
			  <td rowspan="2"><b>Positive</b> ({$feedback.state.five_pt+$feedback.state.four_pt}%)</td>
			  <td><span class="left">5 Stars ({$feedback.state.five_star})</span>
				<div class="ratebar ratebar-s"><span style="width:{$feedback.state.five_pt}%;"></span></div></td>
			</tr>
			<tr>
			  <td><span class="left">4 Stars ({$feedback.state.four_star}) </span>
				<div class="ratebar ratebar-s"><span style="width:{$feedback.state.four_pt}%;"></span></div></td>
			</tr>
			<tr>
			  <td><b>Neutral</b> ({$feedback.state.three_pt}%) </td>
			  <td><span class="left">3 Stars ({$feedback.state.three_star}) </span>
				<div class="ratebar ratebar-s"><span style="width:{$feedback.state.three_pt}%;"></span></div></td>
			</tr>
			<tr>
			  <td rowspan="2"><b>Negative</b> ({$feedback.state.one_pt+$feedback.state.two_pt})</td>
			  <td><span class="left">2 Stars ({$feedback.state.two_star}) </span>
				<div class="ratebar ratebar-s"><span style="width:{$feedback.state.two_pt}%;"></span></div></td>
			</tr>
			<tr>
			  <td><span class="left">1 Stars ({$feedback.state.one_star}) </span>
				<div class="ratebar ratebar-s"><span style="width:{$feedback.state.one_pt}%;"></span></div></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="note"><span class="t">Note:</span><span class="c">All information displayed is based on feedback received for this product over the past 6 months.</span></div>
	  <div class="clear"></div>
	</div>
	<div class="rating-detail">
		<table width="100%" class="rating-table widthfixed">
		  <thead>
			<tr>
			  <th class="th3">Buyer</th>
			  <th class="th2">Transaction Details</th>
			  <th class="th4">Feedback</th>
			</tr>
		  </thead>
		  <tbody>
		  {foreach from=$feedback.rows item=row name=row}
			<tr>
			  <td class="td3"><span memberid="138132537" class="name vip-level"> {$row.name}. </span> <span class="state"><b class="css_flag css_{$row.flag_code}" title="{$row.flag_code}"></b></span></td>
			  <td class="td4"><br>
				<div class="total-price"> <span class="price">US {displayPrice price=$row.unit_price} </span> x <span>{$row.quantity} piece</span> </div></td>
			  <td class="td2">
			  	<div class="feedback-star star-block">
					<ul class="rate txt-16">
					   <li><span class="icon-star"><span>1</span></span></li>
					   <li><span class="icon-star"><span>2</span></span></li>
					   <li><span class="icon-star"><span>3</span></span></li>
					   <li><span class="icon-star"><span>4</span></span></li>
					   <li><span class="icon-star"><span>5</span></span></li>
					</ul>
					<ul class="rate txt-16 active" style="width:{$row.rating/5*100}%">
					   <li><span class="icon-star"><span>1</span></span></li>
					   <li><span class="icon-star"><span>2</span></span></li>
					   <li><span class="icon-star"><span>3</span></span></li>
					   <li><span class="icon-star"><span>4</span></span></li>
					   <li><span class="icon-star"><span>5</span></span></li>
					</ul>
				</div>
				<div class="feedback-date">{$row.add_date}</div>
				<div class="feedback"> <span>{$row.feedback}</span> </div>
			  </td>
			</tr>
		  {/foreach}
		  </tbody>
		</table>
	</div>
</div>
{else}
<div class="no-feedback">No&nbsp;Feedback.</div>
{/if}