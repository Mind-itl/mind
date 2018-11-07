<?php
	require __DIR__ . '/vendor/autoload.php';

	use phpseclib\Crypt\RSA;

	function generate_keys(): array {
		$rsa = new RSA();
		$keys = $rsa->createKey(1024);
		return $keys;
	}

	function get_sign(string $text, string $private_key): string {
		$rsa = new RSA();
		$rsa->loadKey($private_key);
		return $rsa->sign($text);
	}

	function verify_sign(string $text, string $sign, string $public_key): bool {
		$rsa = new RSA();
		$rsa->loadKey($public_key);
		return $rsa->verify($text, $sign);
	}

	$text = "I promise you there will be red compot in canteen";

	$keys = generate_keys();
	$sign = get_sign($text, $keys["privatekey"]);

	if (verify_sign($text, $sign, $keys["publickey"])) {
		echo "Verified";
	} else {
		echo "Not verified";
	}
?>
