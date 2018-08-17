<?php
	require_once "utils.php";

	check_logined();
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Мой профиль</title>
		<?php default_meta("profile"); ?>
	</head>
	<body>
		<div class="loader pre" style="visibility: visible;">
			<hr><hr><hr><hr>
		</div>
		<div class="container" style="display: none;">
			<div class="row">
				<?php menu(); ?>
				<div class="col-md-7 col-md-offset-1">
					<div class="anketa">
						<div class="info">
							<?php
								$name = get_curr()->is_student() ? "gi" : "gi ft";
								$name = get_curr()->get_full_name($name);
							?>
							<h2>Здравствуйте, <?= $name ?></h2><br>
							<?php
								if (get_curr()->is_student()) {
									$points = get_curr()->get_points();
									$noun = get_points_in_case($points);
									
									echo "<h2>У Вас на счету $points $noun</h2>";
								}
								else {
									$str = "";
									foreach (get_curr()->get_roles() as $role) {
										$roles_r = [
											"predmet" => "учитель-предметник",
											"classruk" => "классный руководитель",
											"diric" => "директор",
											"vospit" => "воспитатель",
											"zam" => "завуч"
										];
										$rol = $roles_r[$role] ?? $role;
										$str .= "$rol, ";
									}  
									$str = substr($str, 0, -2);
									echo "<h2>Должность: $str";
								}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-3 today-col">
					<span class="today">
						Сегодня: <?= today_rus(date("l")) ?>, <?php echo date("d.m.Y");?>
					</span>
					<span class="timetable">
						<table class="table table-bordered" style="margin-top: 20px;">
							<tr>
								<td>Математика</td>
								<td>203</td>
							</tr>
							<tr>
								<td>Математика</td>
								<td>203</td>
							</tr>
							<tr>
								<td>Русский язык</td>
								<td>203</td>
							</tr>
							<tr>
								<td>Биология</td>
								<td>316</td>
							</tr>
							<tr>
								<td>География</td>
								<td>316</td>
							</tr>
							<tr>
								<td>Физическая культура</td>
								<td>115</td>
							</tr>
							<tr>
								<td>Подготовка к ОГЭ (русский язык)</td>
								<td>104</td>
							</tr>
							<tr>
								<td>Подготовка к ОГЭ (русский язык)</td>
								<td>104</td>
							</tr>
						</table>
					</span>
				</div>
			</div>
		</div>
	</body>
</html>