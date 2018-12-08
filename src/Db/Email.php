<?php
	namespace Mind\Db;

	use Mind\Db\Db;
	use Mind\Users\{User, Teacher, Student};

	class Email {
		private static $mailer;

		public static function init(): void {
			$transport = new \Swift_SmtpTransport(MAIL_ADDRESS, 25);
			$transport
				->setUsername(MAIL_USER)
				->setPassword(MAIL_PASSWORD);

			static::$mailer = new \Swift_Mailer($transport);
		}

		public static function send(string $to_email, string $title, string $body): void {
			$message = new \Swift_Message($title);
			$message
				->setFrom([MAIL_FROM_EMAIL => MAIL_FROM_NAME])
				->setTo([$to_email])
				->setBody($body);

			$result = static::$mailer->send($message);
		}

		public static function get_mailer(): \Swift_Mailer {
			return static::$mailer;
		}
	}

	if (MAIL)
		Email::init();
?>
