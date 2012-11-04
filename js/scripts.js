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

$('.shipped-wrap').ready( function() {
	$('.shipped-item').wookmark({
		offset: 10,
		container: $('.shipped-wrap'),
	});
})

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

/*!
jQuery Wookmark plugin 0.5
@author Christoph Ono (chri@sto.ph or @gbks)
@license Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
*/
$.fn.wookmark=function(a){if(!this.wookmarkOptions){this.wookmarkOptions=$.extend({container:$("body"),offset:2,autoResize:false,itemWidth:$(this[0]).outerWidth(),resizeDelay:50},a)}else if(a){this.wookmarkOptions=$.extend(this.wookmarkOptions,a)}if(!this.wookmarkColumns){this.wookmarkColumns=null;this.wookmarkContainerWidth=null}this.wookmarkLayout=function(){var a=this.wookmarkOptions.itemWidth+this.wookmarkOptions.offset;var b=this.wookmarkOptions.container.width();var c=Math.floor((b+this.wookmarkOptions.offset)/a);var d=Math.round((b-(c*a-this.wookmarkOptions.offset))/2);var e=0;if(this.wookmarkColumns!=null&&this.wookmarkColumns.length==c){e=this.wookmarkLayoutColumns(a,d)}else{e=this.wookmarkLayoutFull(a,c,d)}this.wookmarkOptions.container.css("height",e+"px")};this.wookmarkLayoutFull=function(a,b,c){var d=[];while(d.length<b){d.push(0)}this.wookmarkColumns=[];while(this.wookmarkColumns.length<b){this.wookmarkColumns.push([])}var e,f,g,h=0,i=0,j=this.length,k=null,l=null,m=0;for(;h<j;h++){e=$(this[h]);k=null;l=0;for(i=0;i<b;i++){if(k==null||d[i]<k){k=d[i];l=i}}e.css({position:"absolute",top:k+"px",left:l*a+c+"px"});d[l]=k+e.outerHeight()+this.wookmarkOptions.offset;m=Math.max(m,d[l]);this.wookmarkColumns[l].push(e)}return m};this.wookmarkLayoutColumns=function(a,b){var c=[];while(c.length<this.wookmarkColumns.length){c.push(0)}var d=0,e=this.wookmarkColumns.length,f;var g=0,h,i;var j=0;for(;d<e;d++){f=this.wookmarkColumns[d];h=f.length;for(g=0;g<h;g++){i=f[g];i.css({left:d*a+b+"px",top:c[d]+"px"});c[d]+=i.outerHeight()+this.wookmarkOptions.offset;j=Math.max(j,c[d])}}return j};this.wookmarkResizeTimer=null;if(!this.wookmarkResizeMethod){this.wookmarkResizeMethod=null}if(this.wookmarkOptions.autoResize){this.wookmarkOnResize=function(a){if(this.wookmarkResizeTimer){clearTimeout(this.wookmarkResizeTimer)}this.wookmarkResizeTimer=setTimeout($.proxy(this.wookmarkLayout,this),this.wookmarkOptions.resizeDelay)};if(!this.wookmarkResizeMethod){this.wookmarkResizeMethod=$.proxy(this.wookmarkOnResize,this)}$(window).resize(this.wookmarkResizeMethod)}this.wookmarkClear=function(){if(this.wookmarkResizeTimer){clearTimeout(this.wookmarkResizeTimer);this.wookmarkResizeTimer=null}if(this.wookmarkResizeMethod){$(window).unbind("resize",this.wookmarkResizeMethod)}};this.wookmarkLayout();this.show()}