<?php
	namespace Mind\Controls;

	use Mind\Server\{Control, Utils};
	use Mind\Db\Statuses;
	use Mind\Users\{User, Teacher, Student, Role};

	class Status extends Control {
		public function has_access(array $args): bool {
			return Utils::is_logined();
		}

		public function get_data(array $args): array {
			$groups = Statuses::get_students_by_classes();

			foreach ($groups as &$group) {
				$group["can_edit"] =
					Utils::get_curr()->has_role(Role::ZAM) ||
					Utils::get_curr()->has_role(Role::SOCPED) ||
					Utils::get_curr()->has_role(Role::DIRIC) ||
					(
						Utils::get_curr()->has_role(Role::CLASSRUK) &&
						Utils::get_curr()->get_role_arg(Role::CLASSRUK) == $group["name"]
					) ||
					(
						Utils::get_curr() instanceof Student &&
						Utils::get_curr()->get_group_name() == $group["name"]
					);
			}

			return [
				"statuses" => Statuses::get_types(),
				"groups" => $groups
			];
		}
	}
?>
