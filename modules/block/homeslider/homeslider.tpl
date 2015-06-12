<div class="home-page-slider">
	<div class="iosSlider full-slider home-slider">
		<div class="slider-style slider-style-home">
			<div class="slider">
				<div class="item item1">
					<div class="bg-img"><img src="{$img_dir}banner/home-slider1.jpg"></div>
					<a style="background: url({$img_dir}pattern_vp.png)" href="#" class="vp-2-brands">
					<div class="inner">
					  <div class="wrapper"> <strong style="color:#ea3e3b">- New Year Discount -</strong>
						<h2 class="small-title">Up to 70% off</h2>
						<p class="info"></p>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
				<div class="item item1">
					<div class="bg-img"><img src="{$img_dir}banner/home-slider2.jpg"></div>
					<a style="background: url({$img_dir}fete_pattern.jpg)" href="#">
					<div class="inner">
					  <div class="wrapper"> <strong class="status new">Inspiration</strong>
						<h2 class="small-title">Men's sneakers<br></h2>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
				<div class="item item1">
					<div class="bg-img"><img src="{$img_dir}banner/home-slider3.jpg"></div>
					<a style="background: url({$img_dir}pattern-stripes-pink.png)" href="#">
					<div class="inner">
					  <div class="wrapper">
						<strong class="status new">Fashion</strong>
						<h2 class="small-title">Women's Pumps</h2>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
			</div>
		</div>
		<div class="paging">
			<div class="box"><span>1</span></div>
			<div class="box"><span>2</span></div>
			<div class="box"><span>3</span></div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.slider-style-home').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navSlideSelector: $('.home-slider .paging .box'),
		onSliderLoaded: callbackSliderLoadedChanged,
		onSlideChange: callbackSliderChanged,
	});
})
</script>
<section class="about-us">
<div class="pt-standard">
  <div class="inner" align="center">
	<h2><span>{$shop_name}</span> Christian louboutin shoes shop online!</h2>
	<div class="mask-text">
	  <p class="txt-14"> One of those iconic red soles and peek you trot style, you know.Slide a pair of high heels or sling standing in a red handbag from Christian louboutin, perfect finish any ensemble.Both classic and avant-garde (think edge, crystal and peak), it is still necessary the epitome of style. </p>
  </div>
</div>
</section>