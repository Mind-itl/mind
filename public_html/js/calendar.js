$(function() {
	'use strict';
	$('#calendar').fullCalendar({
		defaultView: 'month'
	});

	const addEvent = (event) => {
		$('#calendar').fullCalendar('renderEvent', event);
	};

	addEvent({
		title: 'event',
		start: moment("2018-07-23T09:00:00"),
		allDay: true
	});
});