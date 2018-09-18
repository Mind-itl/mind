<?php
	class Menu_control extends Control {
		private $button_view;
		private $buttons = [
			// [role, title, url, class (maybe)]
			["all", "Мой профиль", "/"],
			["student", "Выписка по баллам", "/points"],
			["student", "Передать баллы", "/give"],
			["teacher", "Изменить баллы", "/award"],
			["classruk", "Выписка по классу", "/class"],
			["all", "Расписание", "/timetable"],
		];

		public function __construct() {
			$this->button_view = load_view("menu_button");
			parent::__construct("menu");
		}

		private function buttons(): string {
			$b = "";
			foreach ($this->buttons as $button) {
				if ($button[0]=="all" || get_curr()->has_role($button[0])) {
					$b .= $this->button($button[1], $button[2], $button[3] ?? "");
				}
			}
			return $b;
		}

		private function button(string $title, string $link, string $class) {
			return $this->process_view($this->button_view, [
				"URL" => $link,
				"TITLE" => $title,
				"CLASS" => $class
			], []);
		}

		protected function get_data(array $args): array {
			return [
				"BUTTONS" => $this->buttons()
			];
		}		
	}
?>
