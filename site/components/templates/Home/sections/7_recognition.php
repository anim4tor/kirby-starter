<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="recognition radius" theme="light" >
	<div class="flex align__center inner-x__1 gap__2">
		<div class="no__wrap">
			<div class="upper op__6">Featured in</div>
		</div>
		<div class="logo-ticker-container">
			<div class="logo-ticker-track">
				<div class="logo-ticker-group flex gap__1 innex-x__1 inner-y__1">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>

				</div>
				<div class="logo-ticker-group flex gap__2 innex-x__1 inner-y__1" aria-hidden="true">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>

				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
