<?php
	use phpseclib\Crypt\RSA;

	function generate_rsa_keys(): array {
		$rsa = new RSA();
		$keys = $rsa->createKey(1024);
		return [
			"public" => $keys["publickey"],
			"private" => $keys["privatekey"]
		];
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

	// returns private key or null if keys have been already created 
	function generate_keys(User $user): ?string {
		if (get_public_key($user) !== null) {
			return null;
		}

		$keys = generate_rsa_keys();

		safe_query("
			INSERT INTO public_keys (LOGIN, KEY)
			VALUES (?s, ?s)
			", $user->get_login(), $keys["public"]
		);

		return $keys["private"];
	}

	function get_public_key(User $user): ?string {
		$r = safe_query("
			SELECT KEY FROM public_keys WHERE LOGIN = ?s
			", $user->get_login()
		);

		if ($r = $r->fetch_assoc()) {
			return $r["KEY"];
		}

		return null;
	}
?>
