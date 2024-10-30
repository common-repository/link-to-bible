<?php

namespace LTB\Dto;

class Filter {
	private $hook;
	private $callable;
	private $priority;
	private $acceptedArgs;

	public function __construct($hook, $callable, $priority = 10, $acceptedArgs = 1) {

		$this->hook = $hook;
		$this->callable = $callable;
		$this->priority = $priority;
		$this->acceptedArgs = $acceptedArgs;
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

	/**
	 * @return int
	 */
	public function getPriority() {
		return $this->priority;
	}

	/**
	 * @return int
	 */
	public function getAcceptedArgs() {
		return $this->acceptedArgs;
	}
}
