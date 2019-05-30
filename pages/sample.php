<?php
/*
 *
 * This is a sample page you can copy and use as boilerplate for any new page.
 *
 */
require_once __DIR__ . '/../inc/above.php';

// Page-specific preparatory code goes here.

?>





<!-- Sample Page Content -->
<section class="intro-section">
	<h5>What happens to the sample?</h5>
	<br>
	<p><?php echo getContent( 'Not sure yet.', 'about_the_sample', $pageId ) ?></p>
</section>
<!-- END: Sample Page Content -->





<?php require_once __DIR__ . '/../inc/below.php'; ?>
