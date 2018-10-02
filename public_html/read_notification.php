<?php
	require_once __DIR__."/../lib/utils.php";
	check_logined();

	if (!isset_post_fields("id"))
		exit();

	$id = $_POST["id"];

	safe_query("
		UPDATE notifications
		SET READED=1
		WHERE
			ID=?i AND
			TO_USER=?s
		", $id, get_curr()->get_login());
?>
