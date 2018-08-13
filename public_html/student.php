<?php 
	require_once "utils.php";
	require_once "users.php";
	check_logined();

	$student_login = explode('/', $_SERVER['REQUEST_URI'])[2];
	$student = get_user($student_login, 'student');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<?php default_meta("student"); ?>
		<link rel="stylesheet" href="/css/points.css">
	</head>
	<body>
		<div class="loader pre" style="visibility: visible;">
			<hr><hr><hr><hr>
		</div>
		<div class="container" style="display: none;">
	        <div class="row">
				<?php menu(); ?>
				<div class="col-md-12">
					<span class="span-point">
						Текущее количество баллов: 
					</span>
					<span class="span-points">
						<?= $student->get_points() ?>	
					</span>
					<table class="table table-bordered table-hover">
						<tr>
							<th>Дата</th>
							<th>Отправитель</th>
							<th>Причина</th>
							<th>Количество</th>
						</tr>
						<?php
							foreach ($student->get_transactions() as $trans) {
								if (isset($trans["FROM_LOGIN"])) {
									$name = get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");

									if ($trans["FROM_LOGIN"] == $student->get_login())
										$cls = "from_me";
									else
										$cls = "not_from_me";
								} else
									$cls = "not_from_me";
									$name = "";
									
								?>
								<tr>
									<td><?= $trans["TIME"]   ?></td>
									<td>
										<?php
											if (isset($trans["FROM_LOGIN"]))
												echo get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");
										?>
									</td>
									<td>
										<?php
											$code = $trans["CAUSE"];

											$special_codes = [
												'D' => 'Начальные баллы',
												'C' => 'Передача баллов',
											];
											if (isset($special_codes[$code]))
												echo $special_codes[$code]; 
											else
												echo get_cause_title($code);
										?>
									</td>
									<td class="<?=$cls?>">
										<?= $cls == "from_me" ? -$trans["POINTS"] : $trans["POINTS"] ?>	
									</td>
								</tr>
								<?php
							}
						?>
						<tr>
							<td colspan="3" class="summ">
								Итого:
							</td>
							<td class="no-right">
								<?= $student->get_points() ?>	
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>