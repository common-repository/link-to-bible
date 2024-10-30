<?php

namespace LTB;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ClassExplorer {
	/**
	 * @return \Generator<class-string>
	 */
	public static function extractClassesBy($interface) {
		$dir = new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($dir);

		/** @var \SplFileInfo $file */
		foreach ($files as $file) {
			if ($file->getExtension() !== 'php') {
				continue;
			}

			$class = explode('classes/', $file->getRealPath())[1];
			$class = 'LTB\\' . \str_replace(['/', '.php'], ['\\', ''], $class);

			if (!in_array($interface, \class_implements($class))) {
				continue;
			}

			yield $class;
		}
	}
}
