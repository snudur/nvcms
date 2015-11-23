<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FormableImageTrait;
use App\Traits\FormableFileTrait;
use App\Traits\ParentableTrait;
use App\Traits\TranslationTrait;
use App\Traits\FormableExtrasTrait;


class Formable extends Model
{
	use FormableImageTrait, ParentableTrait, TranslationTrait, FormableFileTrait, FormableExtrasTrait;

	protected $casts = [
		'images' => 'json',
		'translations' => 'json',
		'files' => 'json',
		'options' => 'json',
		'extras' => 'json'
	];

	protected $fillableExtras = [];

	public function getFillables()
	{
		return $this->fillable;
	}

	public $parent_key = 'parent_id';

	public $disable_parent_listing = false;
}
