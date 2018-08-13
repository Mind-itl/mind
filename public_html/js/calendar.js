window.addEventListener("load", function() {
	let events = calendar_events_list;
	console.log(events);

	events.forEach(e => {
		$("#calendar-events").append(
				`<li>${e["NAME"]}</li>`
			);
	});
});