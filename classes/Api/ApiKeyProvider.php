<?php

namespace LTB\Api;

use LTB\Options\Options;

class ApiKeyProvider {
	/**
	 * @return string|null
	 */
	public static function provide() {
		$response = HttpClient::request(
			'https://www.bibleserver.com/api/webmasters/key',
			[
				'domain' => Options::getSiteUrl(),
			]
		);

		if (null === $response) {
			return null;
		}

		$html = json_decode($response, true);

		if (\json_last_error() !== JSON_ERROR_NONE) {
			return null;
		}

		return isset($html['data']['api_key']) ? $html['data']['api_key'] : null;
	}
}
