<?php
	namespace Mind\Server;

	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Monolog\ErrorHandler;
	use Monolog\Formatter\LineFormatter;
	use Monolog\Formatter\HtmlFormatter;
	use Monolog\Handler\SwiftMailerHandler;

	Class Log {
		/**
		 * @var Logger $logger
		 */
		private static $logger;

		public static function info($a, $b = []) {
			static::$logger->info($a, $b);
		}
		public static function debug($a, $b = []) {
			static::$logger->debug($a, $b);
		}
		public static function notice($a, $b = []) {
			static::$logger->notice($a, $b);
		}
		public static function warning($a, $b = []) {
			static::$logger->warning($a, $b);
		}
		public static function error($a, $b = []) {
			static::$logger->error($a, $b);
		}
		public static function critical($a, $b = []) {
			static::$logger->critical($a, $b);
		}
		public static function alert($a, $b = []) {
			static::$logger->alert($a, $b);
		}
		public static function emergency($a, $b = []) {
			static::$logger->emergency($a, $b);
		}

		public static function init() {
			$formatter = new LineFormatter(
				"[%datetime%] %channel%.%level_name%:\n%message%\n%context%\n%extra%\n\n"
			);

			$logger = new Logger('main');

			$handler = new StreamHandler(Utils::ROOT.'/errors.log', Logger::NOTICE);
			$handler->setFormatter($formatter);
			$logger->pushHandler($handler);
			
			$mess = new \Swift_Message("Mind error");
			$mess
				->setFrom([MAIL_FROM_EMAIL => MAIL_FROM_NAME])
				->setTo([MAIL_DEBUG_EMAIL])
				->setBody("Mind error");


			$handler = new SwiftMailerHandler(\Mind\Db\Email::get_mailer(), $mess);
			// $formatter = new HtmlFormatter();
			// $handler->setFormatter($formatter);
			$logger->pushHandler($handler);

			ErrorHandler::register($logger);

			$logger->info("start");
			static::$logger = $logger;
		}
	}
?>
