<?php
	require_once ROOT."models/status.php";

	function api_getStatusTypes() {
		return Status_model::get_status_types();
	}
?>
