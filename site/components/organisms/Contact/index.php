<div>
	<div fab data-scroll class="fixed inset__bottom-right inner__1" data-contact-hide>
		<div class="flex" style="--in-delay: 1000ms" data-reveal>
			<button class="button bg__acc " theme="acc" hover="dark" data-contact-toggle >
				<div icon class="grid__stack place__center-center color__invert ">
					<div class="grid place__center-center -wrap-l__01"><?= svg('public/assets/images/ui/ui_contact.svg') ?></div>
				</div>
				<label class="upper"><div>
					<span class="flex inner-r__1"><?= !in_array($page->intendedTemplate(), ['job']) ? 'Start project' : 'Apply for job' ?></span>
				</div></label>
			</button>
		</div>
	</div>
	<section class="contact fixed" data-scroll data-contact data-lenis-prevent>
		<div class="grid place__end-end inner__1 h__100v" >
			<?php !in_array($page->intendedTemplate(), ['job']) ? snippet('organisms/Contact/widget') : snippet('organisms/Contact/career') ?>
		</div>
	</section>
</div>
