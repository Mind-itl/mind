<?php
	declare(strict_types=1);
	
	require_once "users.php";
	require_once "templates.php";

	session_start();
	
	if (isset($_SESSION["login"])) {
		$curr_user = get_user($_SESSION['login'], $_SESSION['role']);
	}

	function get_curr() {
		global $curr_user;
		return $curr_user;
	}

	function is_logined(): bool {
		return isset($_SESSION['login']);
	}

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

	function isset_get_fields(string ...$fields) {
		foreach ($fields as $field) {
			if (!isset($_GET[$field]))
				return false;
		}

		return true;
	}

	function isset_post_fields(string ...$fields) {
		foreach ($fields as $field) {
			if (!isset($_POST[$field]))
				return false;
		}

		return true;
	}

	function redirect($url) {
		?>
		<script>
			window.location="<?=$url?>";
		</script>
		<?php
		exit();
	}

	function get_points_in_case($points) {
		$apoints = abs($points);
		if ($apoints % 10 == 0 || $apoints % 10 >= 5)
			$noun = "баллов";
		elseif ($apoints % 10 == 1)
			$noun = "балл";
		else
			$noun = "балла";

        return $noun;
    }
	
    function check_correct(string $str): bool {
    	return strlen($str) !== 0 &&
    	       preg_match("/^[a-zA-Z0-9_]+$/", $str);
    }

    function tag(string $tag, string $html): string {
    	return "<$tag>$html</$tag>";
    }

    function is_incorrect(string ...$strs): bool {
    	foreach ($strs as $str) {
    		if (!check_correct($str)) {
    			error_log($str);
    			return true;
    		}
    	}

    	return false;
    }
?>