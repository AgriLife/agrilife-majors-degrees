<?php

	// Enqueue scripts
	wp_enqueue_script( 'majors-degrees-search' );

	// Output search data as javascript object
?><script><?php

	$search_terms = get_search_query();

	$mjdq = new WP_Query(array(
		'post_type' => 'majors-and-degrees'
	));
	$mjdids = array();

	foreach ($mjdq->posts as $key => $value) {
		$mjdids[] = $value->ID;
	}

	$mjd_terms = wp_get_object_terms($mjdids, 'keyword');

	// Create JS array for tag names
	$mjd_js_slugs = array();

	foreach ($mjd_terms as $key => $value) {
		$name = str_replace('&amp;', 'and', $value->name);
		$mjd_js_slugs[] = '\'' . $name . '\'';
	}

	$mjd_js_slugs = implode(', ', $mjd_js_slugs);

	// Create JS object attributes for tag/url association
	// Example: {"tag_name": tag_id};
	$mjd_js_urls = array();

	foreach ($mjd_terms as $key => $value) {
		$name = str_replace('&amp;', 'and', $value->name);
		$mjd_js_urls[] = '"' . $name . '":"' . get_term_link($value) . '"';
	}

	$mjd_js_urls = implode(', ', $mjd_js_urls);

	?>

	if(!ag_mjd){
		var ag_mjd = {};
	}
	ag_mjd.availableTags = [<?php echo $mjd_js_slugs; ?>];
	ag_mjd.tagLinks = {<?php echo $mjd_js_urls; ?>};

</script>
<div class="majors-degrees-search-form">
	<label for="searchforminput">
		<h4>Search Majors and Degrees</h4>
	</label>
	<form role="search" class="majors-degrees-searchform" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>"">
		<input id="searchforminput" type="text" value=""><?php
			do_action('majors_degrees_searchform_fields');
		?>
		<p class="majors-degrees-search-form-message" style="color:red"></p>
	</form>
</div>
