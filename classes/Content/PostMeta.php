<?php

namespace LTB\Content;

use LTB\Config;
use LTB\Options\Options;

class PostMeta {
	/**
	 * @var \stdClass
	 */
	private $post;

	private function __construct($post) {
		$this->post = $post;
	}

	public static function create($post) {
		return new self($post);
	}

	/**
	 * @return bool
	 */
	public function isDisabled() {
		return (bool) get_post_meta($this->post->ID, 'LTB_DISABLE', true);
	}

	/**
	 * @return bool
	 */
	public function isFiltered() {
		return (bool) get_post_meta($this->post->ID, '_ltb_last', true);
	}

	/**
	 * @return string
	 */
	public function getBible() {
		return get_post_meta($this->post->ID, 'LTB_BIBLE_VERSION', true) ?: null;
	}

	/**
	 * @return string|null
	 */
	public function getLastUsedBible() {
		return get_post_meta($this->post->ID, '_ltb_translation', true) ?: null;
	}

	public function getBibleToUse() {
		$bibleAbbr = self::getBible() ?: Options::getBible();
		$masterdata = BibleProvider::getBiblesMapping();

		return isset($masterdata[$bibleAbbr]) ? $masterdata[$bibleAbbr] : $bibleAbbr;
	}

	public function shouldBeFiltered() {
		if ($this->post->type === 'attachment') {
			return false;
		}

		if ($this->isDisabled()) {
			return false;
		}

		if ($this->isFiltered() || self::getLastUsedBible() === self::getBibleToUse()) {
			return false;
		}

		return true;
	}

	public function update() {
		\update_post_meta($this->post->ID, '_ltb_last', time());
		\update_post_meta($this->post->ID, '_ltb_translation', $bibleAbbr = self::getBibleToUse());
		\update_post_meta($this->post->ID, '_ltb_version', Config::get()->getVersion());
		\update_post_meta($this->post->ID, '_ltb_lang', BibleProvider::getLocaleForBible($bibleAbbr));
	}

	public function delete() {
		\delete_post_meta($this->post->ID, '_ltb_last');
		\delete_post_meta($this->post->ID, '_ltb_translation');
		\delete_post_meta($this->post->ID, '_ltb_version');
		\delete_post_meta($this->post->ID, '_ltb_lang');
	}

}
