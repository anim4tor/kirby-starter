<section id="faq" theme="light" class="home__altruism__features relative" >
	<div class="flex align__start justify__space-between inner-x__5 mobile:inner-x__1 inner-t__5" data-scroll>
		<div class="grid__2 mobile:grid__1 justify__space-between gap__1" >
			<h2 class="font__size__2 mobile:font__size__3" data-reveal-text="words"><?= $site->page('Home')->faqHeading()->inline() ?></h2>
		</div>
		<a href="#faqs" data-scroll-to data-reveal style="--delay: 200ms" class="button circle color__acc"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow_down.svg') ?></span></a>
	</div>
	<div id="faqs" class="grid__2 mobile:grid__1 mobile:gap__5 place__start-center inner-x__5 mobile:inner-x__1 inner-y__5 mobile:w__100v mobile:no__overflow" data-scroll data-scroll-repeat >
		<div class="sticky top__0 wrap-r__5 mobile:wrap-r__0 mobile:relative" data-scroll>
			<div class="shape absolute inset__stretch ">
				<shape data-shape data-reveal-shape class="grid__stack place__center-center w__12 absolute left__0 bottom__0" style="transform: rotate(<?= rand(-90, 90) ?>deg)">
					<?= asset('public/assets/images/shape_faq.png') ?>
					<?= svg('public/assets/images/shape_faq_mask.svg') ?>
				</shape>
			</div>
			<figure class="grid relative mobile:inner-x__2" >
				<?php if ($imgs = $site->page('Home')->faqImage()->toFiles()): ?>
					<div class="absolute w__6 mobile:w__10 top__0 left__0 mobile:left__2" data-reveal><?= snippet('atoms/Image', [ 'img' => $imgs->first() ]) ?></div>
					<div class="wrap-l__4 wrap-t__4" data-reveal><?= snippet('atoms/Image', [ 'img' => $imgs->last() ]) ?></div>
				<?php endif ?>
			</figure>
		</div>
		<?php if ($site->page('Home')->faqFeatures()->isNotEmpty()): ?>
		<div class="grid " >
			<ol class="faq__list" data-scroll data-collapsibles=true>
				<?php foreach ($site->page('Home')->faqFeatures()->toStructure() as $faq): ?>
					<collapsible>
						<summary class="inner-y__1" collapsible-trigger>
							<div class="flex gap__3 flex__between flex__top | sm__gap__2">
							    <h4 data-reveal-chars class=" grid__self__start"><?= $faq->summary()->inline() ?></h4>
								<div data-reveal><div class="label flex flex__middle"><span class="font__size__4 icon large color__acc">+</span></div></div>
							</div>
						</summary>
						<detail collapsible-detail>
							<div>
								<div class="grid gap__1 inner-y__1" collapsible-reveal>
									<div class="grid gap__2 inner-b__2">
						    	    	<p><?= $faq->detail()->inline() ?></p>
									</div>
								</div>
							</div>
						</detail>
					</collapsible>
					<div data-scroll data-clip-reveal="left" class="border__top"></div>
				<?php endforeach ?>
			</ol>
		</div>
		<?php endif ?>
	</div>
</section>
