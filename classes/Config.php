<?php

namespace LTB;

use LTB\Content\BibleProvider;

class Config {

	private static $__instance = null;
	private $version;
	private $pluginName;
	private $textDomain;

	private function __construct($version, $pluginName, $textDomain) {
		$this->version = $version;
		$this->pluginName = $pluginName;
		$this->textDomain = $textDomain;
	}

	/**
	 * @return Config
	 */
	public static function create($version, $pluginName, $textDomain) {
		if (null === self::$__instance) {
			self::$__instance = new self($version, $pluginName, $textDomain);
		}

		return self::$__instance;
	}

	/**
	 * @return Config
	 */
	public static function get() {
		if (null === self::$__instance) {
			throw new \LogicException('Config not created yet.');
		}

		return self::$__instance;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return string
	 */
	public function getPluginName() {
		return $this->pluginName;
	}

	/**
	 * @return string
	 */
	public function getTextDomain() {
		return $this->textDomain;
	}

	/**
	 * @return string
	 */
	public static function getLocale() {
		$locale = \get_locale();

		if (empty($locale)) {
			$locale = 'en';
		}

		$locale = \strtolower($locale);

		// exception for chinese
		if (strpos($locale, 'zh_cn') === 0) {
			return 'zh_CN';
		}

		// Shorten locale, because bibleserver.com needs that this way (ISO 639)
		if ((strlen($locale) > 2) and (strpos($locale, "_"))) {
			$locale = substr($locale, 0, strpos($locale, "_"));
		}

		// check if locale is supported
		if (!in_array($locale, BibleProvider::getLocales())) {
			return 'en';
		}

		return $locale;
	}
}
