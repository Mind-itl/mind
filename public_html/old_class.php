<?php
	require_once "utils.php";
	require_once "users.php";
	require_once "db.php";

	check_roles("classruk");

	$class_sum = 0;

	foreach (get_curr()->get_children() as $group) {
		foreach ($group as $student) {
			$class_sum += $student->get_points();
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Выписка по классу</title>
		
		<?php default_meta("points"); ?>

	</head>
	<body>
		<div class="loader" style="visibility: visible;">
	        <hr><hr><hr><hr>
	    </div>
	    <div class="container" style="display: none;">
	        <div class="row">
				<?php
					menu();
					?>

					<div class="col-md-12">
						<span class="span-point" style="font-weight: bold;">Итого по классу:</span>
						<span class="span-points">
							<?= $class_sum ?>
						</span>

						<?php
						foreach (get_curr()->get_children() as $group_name => $group) {
							?>
							<!-- <h1>
								<?=$group_name?>
							</h1> -->
							<table class="table table-bordered table-hover">
								<tr>
									<th>Ученик</th>
									<th>Баллы</th>
									<th>Подробнее</th>
								</tr>
								<?php
									$class_sum = 0;
									foreach($group as $student) {
										$class_sum += $student->get_points();
										?>
										<tr>
											<td>
												<?= $student->get_full_name() ?>
											</td>
											<td>
												<?= $student->get_points() ?>
											</td>
											<td>
												<a href="student/<?= $student->get_login() ?>">Подробнее</a>
											</td>
										</tr>
										<?php
									}
								?>
								<tr>
									<td class="summ">
										Итого:
									</td>
									<td class="no-right" colspan="2">
										<?= $class_sum ?>
									</td>
								</tr>
							</table>
							<?php			
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>