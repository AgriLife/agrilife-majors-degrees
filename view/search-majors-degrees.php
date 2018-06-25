<?php
	$search_terms = get_search_query();

	$mjdq = new WP_Query(array(
		'post_type' => 'majors-and-degrees'
	));
	$mjdids = array();

	foreach ($mjdq->posts as $key => $value) {
		$mjdids[] = $value->ID;
	}

	$mjdterms = wp_get_object_terms($mjdids, 'keyword');

?>
<div class="majors-degrees-search-form">
	<label for="searchforminput">
		<h4>Search Majors and Degrees</h4>
	</label>
	<form role="search" class="majors-degrees-searchform" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>"">
		<select id="searchforminput" id="tags">
			<option value="">Select Keyword</option>
			<?php
				foreach ($mjdterms as $key => $value) {
					echo sprintf('<option value="%s?post_type=majors-and-degrees">%s</option>',
						get_tag_link($value->term_id),
						$value->name
					);
				}
			?>
		</select>
		<?php do_action('majors_degrees_searchform_fields'); ?>
	</form>
</div>
<script type="text/javascript">
	document.querySelector('.majors-degrees-search-form #searchforminput').addEventListener('change', function(){
		document.location.href = this.value;
	});
</script>
