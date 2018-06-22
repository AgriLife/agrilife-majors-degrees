<?php
	$search_terms = get_search_query();
?>

<div class="majors-degrees-search-form">
	<label for="searchforminput">
		<h4>Search Majors and Degrees</h4>
	</label>
	<form role="search" class="majors-degrees-searchform" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<input id="searchforminput" type="text" class="s" name="s" id="s" placeholder="<?php echo $search_terms; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/><br />
		<input type="hidden" name="post_type" value="<?php echo get_post_type(); ?>" />
		<input type="hidden" name="taxonomy" value="keyword" />
		<?php do_action('majors_degrees_searchform_fields'); ?>
	</form>
</div>
