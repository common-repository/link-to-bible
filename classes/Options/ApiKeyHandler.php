<?php

namespace LTB\Options;

use LTB\Api\ApiKeyProvider;
use LTB\Config;

class ApiKeyHandler {
	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public static function handle($options) {
		if (isset($options[Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]) && '1' === $options[Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]) {
			$apikey = ApiKeyProvider::provide();

			if (null !== $apikey) {
				$options[Options::OPTION_API_KEY] = $apikey;
				$options[Options::OPTION_API_KEY_DOMAIN] = Options::getSiteUrl();

				return $options;
			}

			\add_settings_error('apikey', 'error', \__('The API-Key could not be retrieved.', Config::get()->getTextDomain()));

			$options = Options::all();
			$options[Options::OPTION_API_KEY] = $options[Options::OPTION_API_KEY_MANUAL];
			unset ($options[Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]);

			return $options;
		}

		if (!isset($options[Options::OPTION_API_KEY])) {
			\add_settings_error('apikey', 'error', \__('The API-Key must be set.', Config::get()->getTextDomain()));
		}

		return $options;
	}
}
