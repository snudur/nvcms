<?php

namespace App\Traits;

use App\FormableImages;

trait FormableImageTrait {
	public function img() {
		return new FormableImages($this->images, $this);
	}
}