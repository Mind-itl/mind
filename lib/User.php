<?php
	declare(strict_types=1);

	abstract class User {
		protected $_modified = false;
		
		protected $login;
		protected $given_name, $family_name, $father_name;

		/**
		 * Return given name (e.g. `'Roma'`, `'Rinat'`)
		 * 
		 * @return string
		 */
		public function get_given_name(): string {
			return $this->given_name;
		}

		/**
		 * Return family name (e.g. `'Semenov'`, `'Farkhutdinov'`)
		 * 
		 * @return string
		 */
		public function get_family_name(): string {
			return $this->family_name;
		}

		/**
		 * Return father name (e.g. `'Sergeevich'`)
		 * 
		 * @return string
		 */
		public function get_father_name(): string {
			return $this->father_name;
		}

		/**
		 * Return full name with certain format
		 * Format string may contain
		 *   "fm" (family name),
		 *   "gi" (given name),
		 *   "ft" (father name)
		 * keys that will be replaced by names
		 * 
		 * @param string $format Format string 
		 * @return string
		 */
		public function get_full_name(string $format = "fm gi ft"): string {
			$search = array("gi", "ft", "fm");
			$replace = array($this->given_name, $this->father_name, $this->family_name);

			return str_replace($search, $replace, $format);
		}

		/**
		 * Return user's login
		 * 
		 * @return string
		 */
		public function get_login(): string {
			return $this->login;
		}

		/**
		 * Check if user has role (e.g. `'teacher'`, `'student'`, `'classruk'`)
		 * 
		 * @return bool
		 */
		abstract public function has_role(string $role): bool;

		/**
		 * Check if user is student
		 * 
		 * @return bool
		 */
		public function is_student(): bool {
			return $this->has_role("student");
		}

		/**
		 * Check if user is student
		 * 
		 * @return bool
		 */
		public function is_teacher(): bool {
			return $this->has_role("teacher");
		}
	}
?>
