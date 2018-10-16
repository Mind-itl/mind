$(document).ready(function(){
	'use strict';
	$(".unread-notification").mouseover(function() {
		if (!$(this).hasClass("unread-notification"))
			return;

		$(this)
			.removeClass("unread-notification")
			.addClass("read-notification");

		let id = $(this).find(".notification-id").html().trim();
		id = parseInt(id);

		$.ajax({
			method: "POST",
			url: "read_notification",
			data: {
				"id": id
			}
		})
	});
});