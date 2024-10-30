<?php

namespace LTB;

use LTB\Dto\Action;

interface HasActionsInterface {
	/**
	 * @return array<Action>
	 */
	public static function getActions();
}
