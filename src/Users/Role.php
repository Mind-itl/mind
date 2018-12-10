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

	const STUDENT   = "student";
	const PRESIDENT = "president";
	const SECRETAR  = "secretar";
	const DEPUTAT   = "deputat";
	const STAROSTA  = "starosta";

	public static function get_role_name(string $role) {
		return [
			static::TEACHER  => "учитель",
			static::DIRIC    => "директор",
			static::PREDMET  => "предметник",
			static::ZAM      => "заместитель директора",
			static::CLASSRUK => "классный руководитель",
			static::SOCPED   => "социальный педагог",
			static::MEDIC    => "медик",

			static::STUDENT   => "ученик",
			static::PRESIDENT => "президент совета лицеистов",
			static::SECRETAR  => "секретарь совета лицеистов",
			static::DEPUTAT   => "депутат совета лицеистов",
			static::STAROSTA  => "староста"
		][$role];
	}
}
