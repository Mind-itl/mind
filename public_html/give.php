<?php
	require_once "utils.php";

	check_roles("student");

	if (isset_post_fields("login", "points")) {
		$login = $_POST['login'];
		$points = $_POST['points'];

		if (is_incorrect($login, $points)) {
			error_log('incorrect $login $points in give.php:11');
			$result = false;
		} else {
			error_log('error give.php:14');
			$result = get_curr()->give_points($login, intval($points));
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Передать баллы</title>

	<?php default_meta("give"); ?>
</head>;
	<body>
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
					<span class="span-point">Ваш баланс:</span>
					<span class="span-points">
						<?php
							$points = get_curr()->get_points();
							$noun = get_points_in_case($points);

							echo "$points $noun";
						?>
					</span>
					<form action="" method="POST">
						<div class="lab">
							<label for="to">Выберите ученика:</label><br>
							<?php select_student(); ?>
						</div>
						<input placeholder="Введите количество баллов" class="form-control" type="number" name="points" min="0" id="number">
						<!-- <form onsubmit="return false" oninput="level.value = flevel.valueAsNumber">
							<input name="flevel" id="flying" type="range" min="20" max="10000" value="20" step="10">
							<output for="flying" name="level">2350</output>
						</form> -->
						<input type="submit" id="log-in-a">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>