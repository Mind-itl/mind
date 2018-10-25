<?php
	require_once ROOT."models/status.php";

	function api_getStatus() {
		return Status_model::get_students_by_classes();
	}
?>
