document.addEventListener("DOMContentLoaded", function(){
	'use strict';
	$(".unread-notification").mouseover(function() {
		$(this).removeClass("unread-notification").addClass("read-notification");
	});
});