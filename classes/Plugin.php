<?php

namespace LTB;

use LTB\Dto\Filter;
use LTB\Options\Options;

class Plugin implements HasFilterInterface {
	const PLUGIN_ENTRY_FILE_PATH = '../ltb.php';
	const PLUGIN_SLUG = 'ltb_plugin';

	public static $pluginData = [];

	public static function register() {
		if (null !== Options::getApiKey()) {
			return;
		}

		AdminNotifications::setMessage(sprintf(__("<b>Link To Bible</b>: Please go to the %ssettings-page%s to set the API-Key and select the bible version. (No registration is needed!)", "ltb"), '<a href="options-general.php?page=' . Plugin::PLUGIN_SLUG . '">', '</a>'), 600);
	}

	public static function init() {

	}

	public static function addSettingsPage($links, $file) {

		if ($file !== plugin_basename(__FILE__)) {
			return $links;
		}

		$ltb_links = '<a href="' . get_admin_url() . 'options-general.php?page=ltb_plugin">' . __('Settings') . '</a>';
		array_unshift($links, $ltb_links);

		return $links;
	}

	/**
	 * @return array<Filter>
	 */
	public static function getFilters() {
		return [
			new Filter('plugin_action_links', [Plugin::class, 'addSettingsPage'], 10, 2),
		];
	}

	/**
	 * @return \Generator<Filter>
	 */
	public static function getActions() {
		$classes = ClassExplorer::extractClassesBy(HasActionsInterface::class);

		/** @var HasActionsInterface $class */
		foreach ($classes as $class) {
			yield from call_user_func([$class, 'getActions']);
		}
	}

	/**
	 * @return \Generator<Filter>
	 */
	public static function getAllFilters() {
		$classes = ClassExplorer::extractClassesBy(HasFilterInterface::class);

		/** @var HasFilterInterface $class */
		foreach ($classes as $class) {
			yield from call_user_func([$class, 'getFilters']);
		}
	}
}
