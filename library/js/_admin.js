jQuery(document).ready(function($) {
	
	//Remove thead value on thumbanil column
	$('.wp-list-table th.column-thumbnail').each(function(){
		$(this).html('');
	});

//********** SLIDER AIDS ***********//
	// Conditional Slider Template Fixer
	function init_aids () {
		$('.acf_postbox tr.row').each(function(){
		var root = $(this);
		
		var content_row = root.find('td').filter("[data-field_name='content']").parent();
		var content_position_field = root.find('td').filter("[data-field_name='content_position']").parent();
		var images = root.find('td').filter("[data-field_name='images']").parent();
		var image_big_src = root.find('td').filter("[data-field_name='images']").find('img').eq(1).attr('src');

		//root.find('.order').next().prepend('<h3>Slide</h3>');

		function conditional_template(){
			content_row.hide();
			images.hide();
			content_position_field.hide();
			var val = root.find( ".acf-radio-list input:checked" ).val();
		  	if (val === 'Veckans Bok') {
		  		content_row.fadeIn();
				content_position_field.fadeOut();
				images.fadeIn();
		  	};
		  	if (val === 'Featured Content') {
				content_row.fadeIn();
				content_position_field.fadeIn();
				images.fadeIn();
		  	}
		  	if (val === 'Image Only') {
				content_row.fadeOut();
				content_position_field.fadeOut();
				images.fadeIn();
		  	};
		}
		conditional_template();

		root.find( ".acf-radio-list" ).change(function() {
			conditional_template();
		});

		// Content Position Visual Aid
		var markup = '<div class="position_preview slide-box"><div class="preview-img"></div><div class="content-box"></div></div><a class="refresh">Reload Image</a>';
		
		if (root.find('.position_preview').length == 0) {
		    content_position_field.find('td').eq(1).prepend(markup);
		}
		

		var xpos_input = content_position_field.find('input').eq(0);
		var ypos_input = content_position_field.find('input').eq(1);
		var container_width = $( ".slide-box" ).width();
		var container_height = $( ".slide-box" ).height();

		var contentbox = root.find( ".content-box" );

		contentbox.css('left',xpos_input.val()+'%');
		contentbox.css('top',ypos_input.val()+'%');

		contentbox.parent().find('.preview-img').css('background-image', 'url(' + image_big_src + ')');

		root.find('.refresh').on( "click", function() {
			var contentbox = root.find( ".content-box" );
			var image_big_src = root.find('td').filter("[data-field_name='images']").find('img').eq(1).attr('src');
	  		contentbox.parent().find('.preview-img').css('background-image', 'url(' + image_big_src + ')');
		});

		//FIX change!
		$('.has-image').bind('DOMNodeInserted', function(event) {
	             alert('inserted ' + event.target.nodeName + // new node
	           ' in ' + event.relatedNode.nodeName); // parent
	       });

		//xpos_input.val('5');
		//ypos_input.val('40');

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
		});
	}
	init_aids();
	$('.add-row-end').live('click', function(){
		init_aids();
		return false;
	});
	$('.field-repeater-toggle').live('click', function(){
		$('.acf_postbox tr.row').find('tr').removeAttr( "style" );
	});
	
//********** END SLIDER AIDS ***********//

});//End jQuery