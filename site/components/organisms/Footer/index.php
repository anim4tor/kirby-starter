<?php
$_this = 'organisms/Footer/';
if(!$page->isMobile()):
	snippet($_this.'desktop');
else:
	snippet($_this.'desktop');
	
	// snippet($_this.'mobile');
endif;
?>