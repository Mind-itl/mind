<?php
	require_once __DIR__."/../lib/utils.php";
	require_once LIBS."music.php";

	function vote(int $id) {
		$curr_vote = get_music_vote(get_curr());

		if ($curr_vote === -1) {
			add_music_vote(get_curr(), $id);
			return;
		}

		if ($curr_vote == $id)
			remove_music_vote(get_curr());
		else {
			remove_music_vote(get_curr());
			add_music_vote(get_curr(), $id);
		}
	}

	if (isset($_POST['id']) && is_logined()) {
		vote($_POST['id']);
	}

	echo json_encode(get_music());
?>
