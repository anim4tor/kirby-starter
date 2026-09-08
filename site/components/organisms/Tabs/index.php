<tabs data-tabs class="grid gap__1">
	<nav class="flex flex__start gap__05">
		<?php foreach ($tabs as $tab) : ?>
			<a data-tab href="#<?= $tab->label() ?>" class="button has-border" data-label="<?= $tab->label() ?>"><span><?= $tab->label() ?></span></a>
		<?php endforeach ?>
	</nav>
	<div data-pane-container>
		<?php foreach ($tabs as $pane) : ?>
			<?= snippet('molecules/Pane', compact('tabs','pane','counter')) ?>
		<?php endforeach ?>
	</div>
</tabs>