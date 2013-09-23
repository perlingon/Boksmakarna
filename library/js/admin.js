
jQuery(document).ready(function($) {
	
	//Remove thead value on thumbanil column
	$('.wp-list-table th.column-thumbnail').each(function(){
		$(this).html('');
	});

//********** SLIDER AIDS ***********//
	// Conditional Slider Template Fixer
	var content_row = $('.acf_postbox td').filter("[data-field_name='content']").parent();
	var content_position_field = $('.acf_postbox td').filter("[data-field_name='content_position']").parent();
	var image_big_src = $('.acf_postbox td').filter("[data-field_name='images']").find('img').eq(0).attr('src');
	
	function conditional_template(){
		content_row.show();
		content_position_field.show();
		var val = $( ".acf-radio-list input:checked" ).val();
	  	if (val === 'Text' || val ==='Veckans Bok') {
			content_row.hide();
			content_position_field.hide();
	  	};
	}
	conditional_template();

	$( ".acf-radio-list" ).change(function() {
		conditional_template();
	});



	// Content Position Visual Aid
	var markup = '<div class="position_preview slide-box"><div class="preview-img"></div><div class="content-box"></div></div>';
	
	content_position_field.find('td').eq(1).prepend(markup);

	var xpos_input = content_position_field.find('input').eq(0);
	var ypos_input = content_position_field.find('input').eq(1);
	var container_width = $( ".slide-box" ).width();
	var container_height = $( ".slide-box" ).height();

	var contentbox = $( ".content-box" );

	contentbox.css('left','5%');
	contentbox.css('top','40%');

	contentbox.parent().find('.preview-img').css('background-image', 'url(' + image_big_src + ')');
	//FIX change!
	$( ".no-image" ).eq(0).change(function() {
		contentbox.parent().find('.preview-img').css('background-image', 'url(' + image_big_src + ')');
	});

	xpos_input.val('5');
	ypos_input.val('40');

	xpos_input.on("input", null, null, function(){
		var pos = $(this).val() + '%';
		contentbox.css('left', pos);
		});
	ypos_input.on("input", null, null, function(){
		var pos = $(this).val() + '%';
		contentbox.css('top', pos);
		});

	contentbox.draggable({
			containment: "parent",
			cursor: "crosshair",
			opacity: 0.7,
			drag: function(){
	            var position = $(this).position();
	            var xPos = position.left;
	            var yPos = position.top;

	            var xPos_percent = (xPos/container_width)*100;
	            var yPos_percent = (yPos/container_height)*100;

	            $(xpos_input).val(xPos_percent.toFixed(1));
	            $(ypos_input).val(yPos_percent.toFixed(1));
	        }
		});
//********** END SLIDER AIDS ***********//

});//End jQuery