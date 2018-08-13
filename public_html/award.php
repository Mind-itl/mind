<?php
	require_once 'utils.php';
	require_once 'causes.php';

	check_roles("teacher");

	if (isset_post_fields("login", "cause")) {
		$student_login = $_POST["login"];
		$cause = $_POST['cause'];
		
		$result = get_curr()->give_points($student_login, $cause);
	}
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Изменить баллы</title>

		<?php default_meta("award"); ?>

		<script>
			var causes_list = <?= json_encode(causes_list) ?>;
		</script>
	</head>
	<body>
		<div class="loader pre" style="visibility: visible;">
			<hr><hr><hr><hr>
		</div>
		<div class="container" style="display: none;">
	        <div class="row">
				<?php menu(); ?>
				<div class="col-md-10 col-md-offset-1">
				
					<?php
						if (isset($result)) {
							if ($result) {
								?>
								<div class="alert alert-info alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Готово!</strong> Транзакция успешно завершена!
								</div>
								<?php
							} else {
								?>
								<div class="alert alert-info alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Внимание!</strong> Что-то пошло не так!
								</div>
								<?php
							}
						}
					?>

					<form action="" method="POST">
						<label for="award_kind">Выберите ученика:</label><br>
						<?php select_student(); ?>
						<label for="award_kind">Выберите категорию причины:</label><br>
						<select id="award_kind" class="form-control"></select><br>
						<label for="award_cause">Выберите причину:</label>
						<select name="cause" id="award_cause" class="form-control"></select><br>
						<script src="js/cause.js"></script>
						
						<input type="submit" id="log-in-a">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>