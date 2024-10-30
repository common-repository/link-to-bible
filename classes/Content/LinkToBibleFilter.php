<?php

namespace LTB\Content;

use LTB\AdminNotifications;
use LTB\Api\Parser;
use LTB\Dto\Filter;
use LTB\HasFilterInterface;

class LinkToBibleFilter implements HasFilterInterface {
	/**
	 * @param string $content
	 *
	 * @return string
	 */
	public static function filter($content) {
		if (!$content) {
			return $content;
		}

		global $post;

		$meta = PostMeta::create($post);

		if (!$meta->shouldBeFiltered()) {
			return $content;
		}

		wp_insert_post($post); // Do the filtering by saving the post to avoid side-effects with other filtering plugins

		return self::parseContent($content, $meta, true); // Also use the filter here because of some filters of other plugins
	}

	/**
	 * @param string $content
	 *
	 * @return string
	 */
	public static function savePost($content) {

		if (!$content) {
			return $content;
		}

		global $post;

		$meta = PostMeta::create($post);

		if (!$meta->isDisabled()) {
			$meta->update();

			return self::parseContent($content, $meta);
		} elseif ($meta->isFiltered()) {
			$meta->delete();

			return $content;
		}

		return $content;
	}

	private static function parseContent($content, $meta, $ignoreErrors = false) {
		$result = Parser::parse($content, $meta);

		if (null === $result) {
			if (!$ignoreErrors) {
				AdminNotifications::setMessage('Link-To-Bible Error: Error while connecting to bibleserver.com');
			}

			return $content;
		}

		// Check, that the result is no error-string (application-level)
		$resultStart = substr($result, 10);

		if ($resultStart !== substr($content, 10) && false === strpos($resultStart, "<")) {
			if (!$ignoreErrors) {
				AdminNotifications::setMessage(sprintf('%s: "%s"', 'Link-To-Bible Error', $result));
			}

			return $content;
		}

		return $result;
	}

	public static function getFilters() {
		return [
			new Filter('the_content', [LinkToBibleFilter::class, 'filter']),
			new Filter('content_save_pre', [LinkToBibleFilter::class, 'savePost']),
		];
	}
}
