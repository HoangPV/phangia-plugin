<?php


namespace Kenhana\App;


class Excerpt {
	// default length by wordpress
	protected $length = 55;

	protected $types = [
		'short' => 25,
		'regular' => 55,
		'long' => 100,
		'promo' => 15
	];

	protected $more = true;

	public function length($new_length = 55, $more = true) {
		$this->length = $new_length;
		$this->more = $more;

		add_filter('excerpt_more', [$this, 'auto_excerpt_more']);
		add_filter('excerpt_length', [$this, 'new_length']);
	}

	public function new_length() {
		if (isset($this->types[$this->length])) {
			return $this->types[$this->length];
		} else {
			return $this->length;
		}
	}

	public function output() {
		the_excerpt();
	}

	public function continue_reading_link() {
		return '<span class="readmore"><a href="'.get_permalink().'">'.esc_html(__('Read More')).'</a></span>';
	}

	public function auto_excerpt_more() {
		if ($this->more) {
			return ' ';

		} else {
			return ' ';
		}
	}
}