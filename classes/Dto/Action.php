<?php

namespace LTB\Dto;

class Action {
	private $hook;
	private $callable;

	public function __construct($hook, $callable) {

		$this->hook = $hook;
		$this->callable = $callable;
	}

	/**
	 * @return string
	 */
	public function getHook() {
		return $this->hook;
	}

	/**
	 * @return callable
	 */
	public function getCallable() {
		return $this->callable;
	}
}
