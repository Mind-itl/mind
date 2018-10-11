<?php
	require_once LIBS."Excel_reader.php";
	const READERS = LIBS."excel_readers/";

	class Load_control extends Control {
		public function has_access(array $args): bool {
			return is_logined() && get_curr()->is_teacher();
		}

		protected function get_data(array $args): array {
			if (isset_post_fields("excel_type")) {
				$this->post_handle();
			}

			return [
				"readers" => $this->get_readers()
			];
		}

		private function get_readers(): array {
			$arr = [];

			foreach (scandir(READERS) as $reader_file) {
				if ($reader_file == "." || $reader_file == "..")
					continue;
				
				require_once READERS.$reader_file;
				$cls_name = get_reader_name(substr($reader_file, 0, -4));
				
				$arr[] = call_user_func($cls_name."::get_name");
			}

			return $arr;
		}

		private function post_handle() {
			$type = $_POST["excel_type"];
			// todo
		}
	}
?>
