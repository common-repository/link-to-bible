<?php

namespace LTB\Content;

use LTB\Config;
use LTB\Options\Options;

class BibleProvider {
	/**
	 * @var array
	 */
	private static $bibles = [];

	/**
	 * @var array
	 */
	private static $biblesMapping = [];

	private static function loadBiblesData() {
		if ([] !== self::$bibles) {
			return;
		}

		$data = file_get_contents(__DIR__ . '/../../resources/bibleversions.json');
		self::$bibles = json_decode($data, true);
	}

	private static function loadBiblesMapping() {
		if ([] !== self::$biblesMapping) {
			return;
		}

		$data = file_get_contents(__DIR__ . '/../../resources/versionsmapping.json');
		self::$biblesMapping = json_decode($data, true);
	}

	public static function getLocales() {
		self::loadBiblesData();

		return \array_keys(self::$bibles);
	}

	public static function getBibles() {
		self::loadBiblesData();

		return self::$bibles;
	}

	public static function getBiblesMapping() {
		self::loadBiblesMapping();

		return self::$biblesMapping;
	}

	public static function getLocaleForBible($bibleAbbr) {
		if (!Options::isReformatLang()) {
			return Config::getLocale();
		}

		self::loadBiblesData();

		foreach (self::$bibles as $locale => $data) {
			foreach ($data['bible_versions'] as $abbr => $name) {
				if ($bibleAbbr === $abbr) {
					return $locale;
				}
			}
		}

		return 'en';
	}
}
