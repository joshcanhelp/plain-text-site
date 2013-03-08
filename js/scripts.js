/*
General JS/jQuery by Proper Dev
*/

// Shipped code section

$('.shipped-client-section').ready( function() {
	
	// Iterate through all potential sliders
	$.each($('.slider-box'), function() {
		
		var slideCount = 0;
		
		// Iterate through all slides and hide all past the first one
		$.each($(this).children(), function(index, element) {
			slideCount++;
			if (index > 0) $(element).hide();
			else $(element).addClass('showing');
		})
		
		if (slideCount > 1) add_nav($(this));
	
	})
	
	// Add the navigation links to move the slides forward
	function add_nav(addTo) {
		$('<span class="prev-nav">«</span>').appendTo(addTo).click( function(event) {
			change_slide($(event.target).parent(), 'prev');
		});
		$('<span class="next-nav">»</span>').appendTo(addTo).click( function(event) {
			change_slide($(event.target).parent(), 'next');
		});
	}
	
	function change_slide(boxtop, dir) {
		var showing = boxtop.find('.showing');
		showing.hide().removeClass('showing');
		if (dir === 'next') {
			another = showing.next('.slide').length ? showing.next('.slide') : boxtop.children('.slide')[0];
		} else {
			another = showing.prev('.slide').length ? showing.prev('.slide') : boxtop.children('.slide').get(-1);
		}
		console.log(another)
		$(another).fadeIn(100).addClass('showing');
	}
	
})

/*
$('.shipped-wrap').ready( function() {
	$('.shipped-item').wookmark({
		offset: 10,
		container: $('.shipped-wrap'),
	});
})
*/

// Contect page

$('#contact-form-wrap').ready( function() {
	
	var submitBtn = $('#contact-form-wrap input[type=submit]');
	
	// Hide the submit button until something is pressed
	submitBtn.hide();
	
	var previousGroup, currentGroup = '';
	
	// Hide all extra fields
	$('.contact-general, .contact-project, .contact-work, .contact-bug').hide();

	$('.tab-switcher li').click( function() {
		
		submitBtn.show();
		
		previousGroup = currentGroup;
		currentGroup = $(this).attr('data-group');
		
		if (previousGroup !== currentGroup) { 
			
			if (previousGroup.length) $('.' + previousGroup).hide();
			
			$('.' + currentGroup).show();
			$('input#contact-group').val(currentGroup);
			
		}
			
	})
	
})