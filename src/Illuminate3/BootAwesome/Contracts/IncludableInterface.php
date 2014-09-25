<?php namespace Illuminate3\BootAwesome\Contracts;

interface IncludableInterface {

	/**
	 * Include the Bootstrap CDN / Local CSS file
	 *
	 * @param string $type
	 * @param array  $attributes
	 *
	 * @return string
	 */
	public function cssBoot($type = 'cdn', array $attributes = array());
	public function cssFont($type = 'cdn', array $attributes = array());

	/**
	 * Include the Bootstrap CDN JS file. Include jQuery CDN / Local JS file.
	 *
	 * @param string $type
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function js1x($type = 'cdn', array $attributes = array());
	public function js2x($type = 'cdn', array $attributes = array());

}
