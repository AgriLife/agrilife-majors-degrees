// Added to /view/shortcode-search-form.php
jQuery(function() {

	if( ag_mjd.availableTags.length > 0){
		jQuery('.majors-degrees-search-form-message').hide().html('Terms not found');

		jQuery( '#searchforminput' ).autocomplete({
			source: ag_mjd.availableTags,
			change: function( event, ui ){
				var tag = jQuery( '#searchforminput' ).val(),
						link = ag_mjd.tagLinks[tag];

				if(link) {
					jQuery('.majors-degrees-search-form-message').hide();
				}
			},
			focus: function( event, ui ){
				jQuery('.majors-degrees-search-form-message').hide();
			}
		});

		jQuery('form.majors-degrees-searchform').on('submit', function(e){

			e.preventDefault();

			var tag = jQuery( '#searchforminput' ).val(),
					link = ag_mjd.tagLinks[tag];

			if(link){
				jQuery('.majors-degrees-search-form-message').hide();
				document.location.href = link;
			} else {
				jQuery('.majors-degrees-search-form-message').show();
			}

		});

	}

});
