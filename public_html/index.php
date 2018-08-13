<?php
	require_once "utils.php";
	require_once "passwords.php";

	if (is_logined())
		redirect("profile");

	if (isset_post_fields("login", "password")) {
		list($login, $password) = array($_POST["login"], $_POST['password']);

		if (enter_user($login, $password))
			redirect("profile");
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Вход</title>
	<?php default_meta("index"); ?>
</head>
	<body>
		<div class="container">
			<!-- <div class="row">
				<div class="col-md-4 col-md-offset-4">
					<img src="img/mind.png" alt="" class="img-logo">
					<label id="for-logo">Оценочно-воспитательная система Mind</label>
				</div>
			</div> -->
			<div class="row">
				<div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-6 col-xs-12">
					<div class="plitka">
						<form action="" method="POST">
							<div class="input-group form-group">
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
								</span>
								<input
									type="text"
									name="login"
									placeholder="Логин"
									id="exampleInputEmail"
									class="form-control"
									value="<?= $login ?? "" ?>"
								>
							</div>
							<div class="input-group form-group">
								<span class="input-group-addon">
									<i class="fa fa-key" aria-hidden="true"></i>
								</span>
								<input
									type="password"
									name="password"
									placeholder="Пароль"
									id="exampleInputPassword"
									class="form-control"
								>
							</div>
							<input type="submit" id="log-in-s" value="Войти">
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>