<?php
	declare(strict_types=1);

	abstract class User {
		protected $_modified = false;
		
		protected $login;
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
			$search = array("gi", "ft", "fm");
			$replace = array($this->given_name, $this->father_name, $this->family_name);

			return str_replace($search, $replace, $format);
		}

		public function get_login(): string {
			return $this->login;
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