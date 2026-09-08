<div class="flex gap__1 inner-x__1 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="wrap">You didn't find a suitable position? <span class="color__acc">Send us your CV.</span></h3>
	</div>
</div>
<form id="career-form" action="<?= url('contact.json') ?>" method="POST" data-form="contact" class="grid__2 gap__05 inner-x__1 inner__1 border__top">
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Position</label>
		<select name="division" data-contact-input>
			<?php foreach (collection('Jobs') as $job) : ?>
				<option <?= ($job->id() === $page->id()) ? 'selected' : null ?> value="<?= $job->title() . ' - ' . $job->location() ?>"><?= $job->title() . ' - ' . $job->location() ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Name *</label>
		<input type="text" name="name" required placeholder="Your name" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Company</label>
		<input type="text" name="company" placeholder="Current company / school" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Email *</label>
		<input type="email" name="email" required placeholder="name@domain.com" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Phone</label>
		<input type="text" name="phone" placeholder="+420 ..." data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">CV / LinkedIn</label>
		<input placeholder="Link your CV (LinkedIn profile, portfolio, etc.)" name="cv_link" id="cv_link" type="text" maxlength="255" data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Message *</label>
		<textarea name="message" required placeholder="Tell us about yourself..." data-contact-input></textarea>
	</div>

	<div class="span__2" data-form-feedback>
		<div data-form-error class="color__acc"></div>
	</div>

	<div class="span__2 gap__1 grid__2">
		<div class="flex justify__start">
			<?= snippet('atoms/Button', [ 'label' => 'Send', 'icon' => false, 'theme' => 'invert', 'node' => 'type="submit" data-form-submit' ]) ?>
		</div>
		<p class="lower font__size__small op__4">By sending, you automatically agree to the data processing and the terms <a class="link" href="<?= page('privacy')->url() ?>">principles of personal protection data.</a></p>
	</div>

</form>