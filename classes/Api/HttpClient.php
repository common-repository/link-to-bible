<?php

namespace LTB\Api;

use LTB\Config;
use LTB\Options\Options;

class HttpClient {
	/**
	 * @param string $url
	 * @param array $params
	 *
	 * @return string|null
	 */
	public static function request($url, $params) {
		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_REFERER, Options::getSiteUrl());
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, "LinkToBible/" . Config::get()->getVersion());
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$errno = curl_errno($ch);
			$result = curl_exec($ch);

			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);

			if (0 !== $errno || !\in_array($httpCode, [200, 201, 202, 204])) {
				return null;
			}

			return $result;
		}

		$http = [
			'http' => [
				'method'     => 'POST',
				'content'    => http_build_query($params),
				'user_agent' => "LinkToBible/" . Config::get()->getVersion(),
				'header'     => "Referer: " . Options::getSiteUrl()
			]
		];

		$ctx = stream_context_create($http);

		if (!$ctx) {
			return null;
		}

		$fp = fopen($url, 'rb', false, $ctx);

		if (false === $fp) {
			return null;
		}

		try {
			return stream_get_contents($fp) ?: null;
		} finally {
			fclose($fp);
		}
	}
}
