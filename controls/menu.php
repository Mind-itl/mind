<?php
	class Menu_control extends Control {
		private $button_view;
		private $buttons = [
			// [role, title, url, class (maybe)]
			["all", "Профиль", "/"],
			[
				"Баллы",
				["student", "Мои баллы", "/points"],
				["student", "Передать баллы", "/give"],
				["teacher", "Выдать баллы", "/award"],
				["student", "Аукцион", "/auction"]
			],
			["classruk", "Выписка по классу", "/class"],
			["student", "Расписание", "/timetable"],
			["student", "Интернат", "/internat"],
			["vospit", "Интернат", "/internat"],
			["teacher", "Оповестить учеников", "/broadcast"],
			["zam", "Загрузить данные", "/load"]
		];

		protected function get_data(array $args): array {
			$buttons_ans = [];

			foreach ($this->buttons as $buttons) {
				if (is_array($buttons[1])) {
					$buts = [];

					foreach ($buttons as $but) {
						if (is_string($but))
							continue;

						if ($but[0]=="all" || get_curr()->has_role($but[0]))
						$buts[] = [
							"title" => $but[1],
							"url" => $but[2],
						];
					}

					if (count($buts) > 0) {
						$buttons_ans[] = [
							"menu" => true,
							"title" => $buttons[0],
							"items" => $buts
						];
					}

				} else {
					if ($buttons[0]=="all" || get_curr()->has_role($buttons[0]))
						$buttons_ans[] = [
							"title" => $buttons[1],
							"url" => $buttons[2],
							"menu" => false
						];
				}
			}

			return [
				"buttons" => $buttons_ans
			];
		}		
	}
?>
