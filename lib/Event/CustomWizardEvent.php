<?php

namespace OCA\FirstRunWizard\Event;

use OCP\EventDispatcher\Event;

class CustomWizardEvent extends Event {

	private array $slides = [];
	private array $intro = [];

	public function addSlide(string $content): void {
		$this->slides[] = [
			'content' => $content,
		];
	}

	public function getSlides(): array {
		return $this->slides;
	}

	public function setIntro(string $mimetype, string $url): void {
		$this->intro[$mimetype] = $url;
	}


}
