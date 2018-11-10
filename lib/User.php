<?php
	declare(strict_types=1);

	abstract class User {
		protected $_modified = false;
		
		protected $login;
		protected $enter_login;
		protected $given_name, $family_name, $father_name;

		public function get_given_name(): string {
			return $this->given_name;
		}

		public function get_family_name(): string {
			return $this->family_name;
		}

		public function get_father_name(): string {
			return $this->father_name;
		}

		public function get_full_name(string $format = "fm gi ft"): string {
			return $this->get_name($format);
		}

		public function get_name(string $format = "fm gi ft"): string {
			$search = ["gi", "ft", "fm"];
			$replace = [$this->given_name, $this->father_name, $this->family_name];

			return str_replace($search, $replace, $format);
		}

		public function get_names(): array {
			return [
				"given" => $this->get_given_name(),
				"father" => $this->get_father_name(),
				"family" => $this->get_family_name(),
			];
		}

		public function get_login(): string {
			return $this->login;
		}

		public function get_enter_login(): string {
			return $this->enter_login;
		}

		abstract public function has_role(string $role): bool;

		public function is_student(): bool {
			return $this->has_role("student");
		}

		public function is_teacher(): bool {
			return $this->has_role("teacher");
		}
	}
?>
