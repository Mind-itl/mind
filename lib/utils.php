<?php
	declare(strict_types=1);

	const ROOT = __DIR__ . "/../";
	require_once ROOT."config.php";
	
	const CONTROLS = ROOT."controls/";
	const VIEWS = ROOT."views/";
	const LIBS = ROOT."lib/";

	require_once "users.php";
	require_once "notifications.php";
	
	require_once ROOT."vendor/autoload.php";

	function check_logined() {
		if (!is_logined()) {
			redirect("/index");
		}
	}

	function check_roles(string ...$roles) {
		check_logined();

		foreach ($roles as $role) {
			if (!get_curr()->has_role($role))
				redirect("/index");
		}
	}

	function tag(string $tag, string $html): string {
		return "<$tag>$html</$tag>";
	}

	
?>
