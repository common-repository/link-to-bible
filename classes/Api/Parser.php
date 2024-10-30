<?php

namespace LTB\Api;

use LTB\Content\BibleProvider;
use LTB\Content\PostMeta;
use LTB\Options\Options;

class Parser {
	/**
	 * @param string $content
	 * @param PostMeta $postMeta
	 *
	 * @return string|null
	 */
	public static function parse($content, $postMeta) {

		$bibleAbbr = $postMeta->getBibleToUse();

		return HttpClient::request(
			'https://www.bibleserver.com/api/parser',
			[
				'key'  => Options::getApiKey(),
				'text' => $content,
				'lang' => BibleProvider::getLocaleForBible($bibleAbbr),
				'trl'  => $bibleAbbr
			]
		);
	}
}
