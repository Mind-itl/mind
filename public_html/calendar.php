<?php 
	require_once "utils.php";

	check_logined();
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Расписание</title>
		
		<?php default_meta("calendar"); ?>
		
		<link rel='stylesheet' href='css/fullcalendar.css' />

		<script src='js/moment.min.js'></script>
		<script src='js/fullcalendar.min.js'></script>

		<script>
			calendar_events_list = <?= get_events_json() ?>;
		</script>

	</head>
	<body>
		<div class="loader pre" style="visibility: visible;">
			<hr><hr><hr><hr>
		</div>
		<div class="container" style="display: none;">
	        <div class="row">
				<?php menu(); ?>
				<div class="col-md-12">
					<!-- <div id="calendar"></div> -->
				</div>
			</div>
		</div>
		<!-- <script src="js/calendar.js"></script> -->
	</body>
</html>