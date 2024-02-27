<?php

class OC_Template {

	public function __construct(string $app, string $name, string $renderAs = '', bool $registerCall = true) {
	}

	public function fetchPage(?array $additionalParams = null): string {
		return '';
	}

	/**
	 * @param string $key key
	 * @param float|array|bool|integer|string|Throwable $value value
	 * @return bool
	 */
	public function assign(string $key, mixed $value): bool {
		return '';
	}
}
