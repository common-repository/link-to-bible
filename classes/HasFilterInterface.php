<?php

namespace LTB;

use LTB\Dto\Filter;

interface HasFilterInterface {
	/**
	 * @return array<Filter>
	 */
	public static function getFilters();
}
