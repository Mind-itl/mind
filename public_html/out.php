<?php
	require __DIR__."/../vendor/autoload.php";

	setlocale(LC_TIME, "ru_RU.UTF-8");
	session_start();

	$_SESSION['login'] = null;

	\Mind\Server\Utils::redirect("/");
?>
