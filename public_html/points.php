<?php 
	require_once "utils.php";
	require_once "users.php";

	check_roles("student");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Выписка по баллам</title>

	<?php default_meta("points"); ?>

</head>
	<body>
		<div class="container" style="display: none;">
	        <div class="row">
				<?php menu(); ?>
				<div class="col-md-12">
					<span class="span-point">
						Текущее количество баллов: 
					</span>
					<span class="span-points">
						<?= get_curr()->get_points() ?>	
					</span>
					<table class="table table-bordered table-hover">
						<tr>
							<th>Дата</th>
							<th>Отправитель</th>
							<th>Причина</th>
							<th>Количество</th>
						</tr>
						<?php
							foreach (get_curr()->get_transactions() as $trans) {
								if (isset($trans["FROM_LOGIN"])) {
									$name = get_user($trans["FROM_LOGIN"])->get_full_name("fm gi");

									if ($trans["FROM_LOGIN"] == get_curr()->get_login())
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
										<?= $trans["POINTS"] ?>	
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
								<?= get_curr()->get_points() ?>	
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>