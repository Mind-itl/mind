<?php
	require __DIR__."/../vendor/autoload.php";

	use Mind\Db\{Music};
	use Mind\Server\{Utils};

	setlocale(LC_TIME, "ru_RU.UTF-8");
	session_start();

	function vote(int $id) {
		$curr_vote = Music::get_vote(Utils::get_curr());

		if ($curr_vote === -1) {
			Music::add_vote(Utils::get_curr(), $id);
			return;
		}

		if ($curr_vote == $id)
			Music::remove_vote(Utils::get_curr());
		else {
			Music::remove_vote(Utils::get_curr());
			Music::add_vote(Utils::get_curr(), $id);
		}
	}

	function remove(int $id) {
		Music::remove($id);
	}

	if (isset($_POST['id']) && is_logined()) {
		if (isset($_POST['remove']))
			remove($_POST['id']);
		else
			vote($_POST['id']);
	}

	echo json_encode(Music::get());
?>
