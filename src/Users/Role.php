<?php
declare(strict_types=1);

namespace Mind\Users;

use Mind\Db\{Users, Causes, Db, Transactions};

class Role {
	const TEACHER  = "teacher";
	const DIRIC    = "diric";
	const PREDMET  = "predmet";
	const ZAM      = "zam";
	const CLASSRUK = "classruk";
	const PEDORG   = "pedorg";
	const SOCPED   = "socped";
	const MEDIC    = "medic";
	const VOSPIT   = "vospit";

	const STUDENT   = "student";
	const PRESIDENT = "president";
	const SECRETAR  = "secretar";
	const DEPUTAT   = "deputat";
	const STAROSTA  = "starosta";
	const AUCTIONER = "auctioner";

	public static function get_role_name(string $role): string {
		return [
			static::TEACHER  => "учитель",
			static::DIRIC    => "директор",
			static::PREDMET  => "предметник",
			static::ZAM      => "заместитель директора",
			static::CLASSRUK => "классный руководитель",
			static::SOCPED   => "социальный педагог",
			static::PEDORG   => "педагог-организатор",
			static::MEDIC    => "медик",
			static::VOSPIT   => "воспитатель",

			static::STUDENT   => "ученик",
			static::PRESIDENT => "президент совета лицеистов",
			static::SECRETAR  => "секретарь совета лицеистов",
			static::DEPUTAT   => "депутат совета лицеистов",
			static::STAROSTA  => "староста",
			static::AUCTIONER => "ответственный за аукцион"
		][$role];
	}

	/**
	 * @return array<int, string>
	 */
	public static function get_roles(): array {
		return [
			static::VOSPIT,
			static::TEACHER,
			static::DIRIC,
			static::PREDMET,
			static::ZAM,
			static::CLASSRUK,
			static::PEDORG,
			static::SOCPED,
			static::MEDIC,
			static::STUDENT,
			static::PRESIDENT,
			static::SECRETAR,
			static::DEPUTAT,
			static::STAROSTA,
			static::AUCTIONER,
		];
	}

	public static function get_role_arg_name(string $role): string {
		return [
			static::PREDMET  => "предмет",
			static::ZAM      => "зам по ..",
			static::CLASSRUK => "класс",
			static::VOSPIT   => "класс",
		][$role] ?? "";
	}
}
