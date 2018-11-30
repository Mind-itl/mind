<?php
	require __DIR__."/../vendor/autoload.php";
	\Mind\Server\Route::init();

	$_SESSION['login'] = null;

	\Mind\Server\Utils::redirect("/");
?>
