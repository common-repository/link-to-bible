<?php

namespace LTB\Options;

use LTB\Api\ApiKeyProvider;
use LTB\Config;
use LTB\Content\BibleProvider;
use LTB\Dto\Action;
use LTB\HasActionsInterface;

class Options implements HasActionsInterface {
	const OPTION_BASE = 'ltb_options';
	const OPTION_GROUP = 'ltb_plugin_options';
	const OPTION_API_KEY = 'apikey';
	const OPTION_API_KEY_MANUAL = 'api_key_man';
	const OPTION_API_KEY_AUTOMATIC_RETRIEVAL = 'aak_on';
	const OPTION_API_KEY_DOMAIN = 'aak_domain';
	const OPTION_BIBLE_ABBR = 'translation';
	const OPTION_REFORMAT_LANG = 'refformatlang';
	const OPTION_VERSION = 'ltbver';
	const OPTION_BIBLE_LANG = 'biblelang';

	/**
	 * @return array<string,string>
	 */
	public static function all() {
		return get_option('ltb_options', [
			Options::OPTION_REFORMAT_LANG => '1',
			Options::OPTION_VERSION       => Config::get()->getVersion()
		]);
	}

	public static function validateOptions() {
		$options = self::all();

		// Retrieve api-key
		if (null === self::getApiKey()) {
			$apikey = ApiKeyProvider::provide();

			if (null !== $apikey) {
				$options [Options::OPTION_API_KEY] = $apikey;
				$options [Options::OPTION_API_KEY_AUTOMATIC_RETRIEVAL] = '1';
				$options [Options::OPTION_API_KEY_DOMAIN] = Options::getSiteUrl();
			}
		}

		// API-Key: Check for changed domain-name
		if (self::isAutomaticRetrieval() && $options [self::OPTION_API_KEY_DOMAIN] !== Options::getSiteUrl()) {
			$apikey = ApiKeyProvider::provide();
			if (null !== $apikey) {
				$options [Options::OPTION_API_KEY] = $apikey;
				$options [Options::OPTION_API_KEY_DOMAIN] = Options::getSiteUrl();
			}
		}

		// Set ltb-version
		if (!isset($options[Options::OPTION_VERSION]) || $options[Options::OPTION_VERSION] != Config::get()->getVersion()) {
			$options [Options::OPTION_VERSION] = Config::get()->getVersion();
		}

		// Set bible-language
		if (!isset($options[Options::OPTION_BIBLE_LANG])) {
			$options[Options::OPTION_BIBLE_LANG] = Config::getLocale();
		}

		// Set-bible version to first version for language, or 'LUT', if not possible
		if (!isset($options[Options::OPTION_BIBLE_ABBR])) {
			$options[Options::OPTION_BIBLE_ABBR] = 'LUT';

			foreach (BibleProvider::getBibles() as $lang => $bibles) {
				if ($lang === $options[Options::OPTION_BIBLE_ABBR]) {
					foreach ($bibles['bible_versions'] as $abbr => $name) {
						$options[Options::OPTION_BIBLE_ABBR] = $abbr;
						break;
					}
				}
			}
		}

		update_option('ltb_options', $options);
	}

	/**
	 * @return string|null
	 */
	public static function getApiKey($default = null) {
		$options = self::all();

		return !isset($options[self::OPTION_API_KEY]) ? $default : $options[self::OPTION_API_KEY];
	}

	/**
	 * @return string|null
	 */
	public static function getBible($default = null) {
		$options = self::all();

		return !isset($options[self::OPTION_BIBLE_ABBR]) ? $default : $options[self::OPTION_BIBLE_ABBR];
	}

	/**
	 * @return bool
	 */
	public static function isAutomaticRetrieval() {
		$options = self::all();

		return isset($options[self::OPTION_API_KEY_AUTOMATIC_RETRIEVAL]) && $options[self::OPTION_API_KEY_AUTOMATIC_RETRIEVAL] === '1';
	}

	/**
	 * @return bool
	 */
	public static function isReformatLang() {
		$options = self::all();

		return isset($options[self::OPTION_REFORMAT_LANG]) && $options[self::OPTION_REFORMAT_LANG] === '1';
	}

	/**
	 * @return string
	 */
	public static function getSiteUrl() {
		return \get_option('siteurl');
	}

	public static function register() {
		register_setting(
			'ltb_plugin_options',
			self::OPTION_BASE,
			[
				'type'              => 'string',
				'group'             => self::OPTION_GROUP,
				'label'             => '',
				'description'       => '',
				'sanitize_callback' => [ApiKeyHandler::class, 'handle'],
				'show_in_rest'      => false,
			]
		);
	}

	public static function getActions() {
		return [
			new Action('admin_init', [Options::class, 'register'])
		];
	}
}
