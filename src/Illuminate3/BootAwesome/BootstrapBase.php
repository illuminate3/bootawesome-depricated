<?php namespace Illuminate3\BootAwesome;

namespace Illuminate3\BootAwesome;

use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Http\Request;
use Form;

abstract class BootstrapBase {

	const FORM_VERTICAL = 'vertical';
	const FORM_HORIZONTAL = 'horizontal';
	const FORM_INLINE = 'inline';

	const CSS_BOOTSTRAP_CDN = '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css';
	const CSS_BOOTSTRAP_LOCAL = 'assets/css/bootstrap.min.css';
	const CSS_BOOTSTRAP_MAP_LOCAL = 'assets/css/bootstrap.css.map';

	const JS_BOOTSTRAP_CDN = '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js';
	const JS_BOOTSTRAP_LOCAL = 'assets/js/bootstrap.min.js';

	const CSS_FONTAWESOME_CDN = '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css';
	const CSS_FONTAWESOME_LOCAL = 'assets/css/font-awesome.min.min.css';

	const JS_JQUERY_1x_CDN = '//code.jquery.com/jquery-1.11.1.min.js';
	const JS_JQUERY_1x_LOCAL = 'assets/js/jquery-1.11.1.min.js';
	const JS_JQUERY_1x_MAP_LOCAL = 'assets/js/jquery-1.11.1.min.js.map';

	const JS_JQUERY_2x_CDN = '//code.jquery.com/jquery-1.11.1.min.js';
	const JS_JQUERY_2x_LOCAL = 'assets/js/jquery-2.1.1.min.js';
	const JS_JQUERY_2x_MAP_LOCAL = 'assets/js/jquery-2.1.1.min.js.map';

	const JS_MOMENT_CDN = '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js';
	const JS_MOMENT_LOCAL = 'assets/js/moment.min.js';

	const JS_DATETIME_CDN = '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js';
	const JS_DATETIME_LOCAL = 'assets/js/bootstrap-datetimepicker.min.js';

	const CSS_DATETIME_CDN = '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/css/bootstrap-datetimepicker.min.css';
	const CSS_DATETIME_LOCAL = 'assets/css/bootstrap-datetimepicker.min.css';

	/**
	 * Form
	 *
	 * @var \Illuminate\Html\FormBuilder
	 */
	protected $form;

	/**
	 * HTML
	 *
	 * @var \Illuminate\Html\HtmlBuilder
	 */
	protected $html;

	/**
	 * Input
	 *
	 * @var \Illuminate\Http\Request
	 */
	protected $input;

	/**
	 * Form Type
	 *
	 * @var string
	 */
	protected $formType = self::FORM_VERTICAL;

	/**
	 * Form Input Class
	 *
	 * @var string
	 */
	protected $inputClass;

	/**
	 * Form Label Class
	 *
	 * @var string
	 */
	protected $labelClass;

	public function __construct(FormBuilder $form, HtmlBuilder $html, Request $input)
	{
		$this->form = $form;
		$this->html = $html;
		$this->input = $input;
	}

	/**
	 * Set the form type
	 *
	 * @param string $type
	 * @param string $inputClass
	 * @param string $labelClass
	 *
	 * @return void
	 */
	protected function form($type = self::FORM_VERTICAL, $inputClass = '', $labelClass = '') {
		$this->formType = $type;
		$this->inputClass = $inputClass;
		$this->labelClass = $labelClass;
	}

	/**
	 * Set the form type to vertical
	 *
	 * @return self
	 */
	public function vertical() {
		$this->form();

		return $this;
	}

	/**
	 * Set the form type to horizontal
	 *
	 * @param string $inputClass
	 * @param string $labelClass
	 *
	 * @return self
	 */
	public function horizontal($inputClass = '', $labelClass = '') {
		$this->form(self::FORM_HORIZONTAL, $inputClass, $labelClass);

		return $this;
	}

	/**
	 * Set the form type to inline
	 *
	 * @param string $labelClass
	 *
	 * @return self
	 */
	public function inline($labelClass = '') {
		$this->form(self::FORM_INLINE, '', $labelClass);

		return $this;
	}

	/**
	 * Get the form type
	 *
	 * @return string
	 */
	public function getFormType() {
		return $this->formType;
	}

	/**
	 * Include the Bootstrap file
	 *
	 * @param string $type
	 * @param string $location
	 * @param array  $attributes
	 *
	 * @return string
	 */
	protected function add($type, $location, array $attributes = array())
	{
		return $this->html->$type($location, $attributes);
	}

	/**
	 * Create a form label field.
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 *
	 * @return string
	 */
	protected function label($name, $label = null, array $options = array()) {
		$options = array_merge(array('class' => 'control-label ' . $this->labelClass), $options);

		if ($label) {
			return $this->form->label($name, $label, $options) . "\n";
		}

		return '';
	}

	/**
	 * Create a form error helper field.
	 *
	 * @param string                         $name
	 * @param \Illuminate\Support\MessageBag $errors
	 * @param string                         $wrap
	 *
	 * @return string
	 */
	protected function errors($name, $errors = null, $wrap = '<span class="help-block">:message</span>') {
		if ($errors && $errors->has($name)) {
			return $errors->first($name, $wrap) . "\n";
		}

		return '';
	}

	/**
	 * Create a form group element.
	 *
	 * @param string                         $name
	 * @param \Illuminate\Support\MessageBag $errors
	 * @param string                         $class
	 *
	 * @return string
	 */
	protected function group($name, $errors = null, $class = 'form-group')
	{
		$return = '<div class="' . $class;

		if ($errors && $errors->has($name)) {
			$return .= ' has-error';
		}

		$return .= '">' . "\n";

		return $return;
	}

	/**
	 * Create a form input field.
	 *
	 * @param string                         $type
	 * @param string                         $name
	 * @param string                         $value
	 * @param string                         $label
	 * @param \Illuminate\Support\MessageBag $errors
	 * @param string                         $icon (do not use the first fa)
	 * @param array                          $options
	 * @param array                          $parameters
	 *
	 * @return string
	 */
	protected function input($type = 'text', $name, $label = null, $value = null, $errors = null, $icon = null, array $options = array(), array $parameters = array())
	{
		$options = array_merge(array('class' => 'form-control', 'placeholder' => $label), $options);

		$return = $this->group($name, $errors);
		$return .= $this->label($name, $label);

		if (!$value) {
			$value = $this->input->get($name);
		}

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= $this->group('', null, $this->inputClass);
		}

		switch ($type) {
			case 'datetime':
			case 'date':
			case 'time':
					$return .= '<div id="' . $name . '_' . $type .  '" class="input-group ' . $type . '">';
					$return .= $this->form->text($name, $value, $options);
					$return .= '<span class="input-group-addon">' . "\n" . '<span class="glyphicon glyphicon-' . ($type == 'time' ? 'time' : 'calendar')  . '"></span>' . "\n" . '</span>' . "\n" . '</div>' . "\n";
					$return .= '<script type="text/javascript">$(function() { $("#' . $name . '_' . $type . '").datetimepicker({ ';

					switch ($type) {
						case 'time':
							$return .= 'pickDate: false, ';
							break;
						case 'date':
							$return .= 'pickTime: false, ';
							break;
						case 'datetime':
						default:
					}

					$return .= implode(', ', array_map(function ($value, $key) { return $key . ': "' . $value . '"'; }, $parameters, array_keys($parameters)));
					$return = rtrim($return, ', ');
					$return .= ' }); });</script>' . "\n";
				break;
			case 'password':
			case 'file':

				if ( is_null($icon) ) {
					$return .= $this->form->$type($name, $options) . "\n";
				} else {
					$return .= '<div class="input-group">' . "\n";
					$return .= '<span class="input-group-addon"><i class="fa fa-' . $icon . '"></i></span>' . "\n";
					$return .= $this->form->$type($name, $options) . "\n";
					$return .= '</div>' . "\n";
				}

//				$return .= $this->form->$type($name, $options) . "\n";
				break;
			case 'text':
			case 'hidden':
			case 'email':
			case 'textarea':

				if ( is_null($icon) ) {
					$return .= $this->form->$type($name, $value, $options) . "\n";
				} else {
					$return .= '<div class="input-group">' . "\n";
					$return .= '<span class="input-group-addon"><i class="fa fa-' . $icon . '"></i></span>' . "\n";
					$return .= $this->form->$type($name, $value, $options) . "\n";
					$return .= '</div>' . "\n";
				}

//				$return .= $this->form->$type($name, $value, $options) . "\n";
				break;
			default:
				$return .= $this->form->input($type, $name, $value, $options) . "\n";
		}

		$return .= $this->errors($name, $errors);

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= '</div>' . "\n";
		}

		$return .= '</div>' . "\n";

		return $return;
	}

	/**
	 * Create a form select field.
	 *
	 * @param string                         $name
	 * @param string                         $label
	 * @param array                          $list
	 * @param string                         $selected
	 * @param \Illuminate\Support\MessageBag $errors
	 * @param array                          $options
	 *
	 * @return string
	 */
	protected function options($name, $label = null, array $list = array(), $selected = null, $errors = null, array $options = array())
	{
		$options = array_merge(array('class' => 'form-control'), $options);

		$return = $this->group($name, $errors);
		$return .= $this->label($name, $label);

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= $this->group('', null, $this->inputClass);
		}

		$return .= $this->form->select($name, $list, $selected, $options) . "\n";
		$return .= $this->errors($name, $errors);

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= '</div>' . "\n";
		}

		$return .= '</div>' . "\n";

		return $return;
	}

	/**
	 * Create a form field.
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $label
	 * @param string $value
	 * @param string $checked
	 * @param array  $options
	 *
	 * @return string
	 */
	protected function field($type, $name, $label = null, $value = null, $checked = null, array $options = array())
	{
		$return = '';

//dd($type);

		if ($this->formType != self::FORM_INLINE) {
			$return .= $this->group($name, null);
		}

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= $this->group('', null, $this->inputClass);
		}

		$return .= '<div class="' . $type . '">' . "\n";
		if ( $type == 'checkbox' ) {
				$return .= '<label>' . "\n";
				$return .= $this->form->$type($name, $value, $checked, $options) . "\n";
				$return .= '&nbsp;' . $label . "\n";
				$return .= '</label>' . "\n";
		} else {
				$return .= $this->label($name, $label);
				$return .= $this->form->$type($name, $value, $checked, $options) . "\n";
		}
		$return .= '</div>' . "\n";

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= '</div>' . "\n";
		}

		if ($this->formType != self::FORM_INLINE) {
			$return .= '</div>';
		}

		return $return;
	}

	/**
	 * Create a form action button.
	 *
	 * @param string $value
	 * @param string $type
	 * @param array  $attributes
	 *
	 * @return string
	 */
	protected function action($type, $value, array $attributes = array())
	{
		switch ($type) {
			case 'submit':
				$attributes = array_merge(array('class' => 'btn btn-primary pull-right'), $attributes);
				break;
			case 'button':
			case 'reset':
			default:
				$attributes = array_merge(array('class' => 'btn btn-default'), $attributes);
		}

		$return = $this->group('', null);

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= $this->group('', null, $this->inputClass);
		}

		$return .= $this->form->$type($value, $attributes) . "\n";

		if ($this->formType == self::FORM_HORIZONTAL) {
			$return .= '</div>' . "\n";
		}

		$return .= '</div>' . "\n";

		return $return;
	}

	/**
	 * Create a button link.
	 *
	 * @param string $type
	 * @param string $location
	 * @param string $title
	 * @param array  $parameters
	 * @param string $secure
	 * @param array  $attributes
	 *
	 * @return string
	 */
	protected function hyperlink($type, $location, $title = null, array $parameters = array(), array $attributes = array(), $secure = null)
	{
		$attributes = array_merge(array('class' => 'btn btn-default'), $attributes);

		switch ($type) {
			case 'linkRoute':
			case 'linkAction':
				$return = $this->html->$type($location, $title, $parameters, $attributes);
				break;
			case 'mailto':
				$return = $this->html->$type($location, $title, $attributes);
				break;
			case 'link':
			case 'secureLink':
			default:
				$return = $this->html->$type($location, $title, $attributes, $secure);
		}

		return $return;
	}

	/**
	 * Create an alert item with optional emphasis.
	 *
	 * @param string  $type
	 * @param string  $content
	 * @param string  $emphasis
	 * @param boolean $dismissible
	 * @param array   $attributes
	 *
	 * @return string
	 */
	protected function alert($type = 'message', $content = null, $emphasis = null, $dismissible = false, array $attributes = array())
	{
		$class = '';

		if($emphasis && is_string($emphasis)){
			$content = '<strong>' . $emphasis . '</strong> ' . $content;
		}

		if ($dismissible) {
			$class = 'alert-dismissable';
		}

		$attributes = array_merge(array('class' => 'alert ' . $class . ' alert-' . ($type != 'message' ? $type : 'default')), $attributes);
		$return = '<div ' . $this->html->attributes($attributes) . '>';

		if ($dismissible) {
			$return .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		}

		$return .= $content . '</div>';

		return $return;
	}


	/**
	 * Create a modal item
	 *
	 * @param string  $id
	 * @param string  $label
	 * @param string  $title
	 * @param string  $route
	 * @param string  $content
	 * @param string  $close
	 * @param string  $button
	 *
	 * @return string
	 */
	protected function modal($id, $label, $title, $route, $method, $content, $close, $button)
	{
		$return = '<div class="modal fade" id="' . $method . '-' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $label . '" aria-hidden="true">' . "\n";
		$return .= '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">' . "\n";
		$return .= '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">' . $close . '</span></button>' . "\n";
		$return .= '<h4 class="modal-title">' . $title . '</h4></div>' . "\n";
		$return .= '<div class="modal-body"><p>' . "\n";
		$return .= $content . "\n";
		$return .= '</p></div>' . "\n";
		$return .= '<div class="modal-footer">' . "\n";
		$return .= Form::open(array('route' => array($route, $id), 'role' => 'form', 'method' => $method, 'class' => 'form-inline')) . "\n";
		$return .= '<button type="button" class="btn btn-default" data-dismiss="modal">' . $close . '</button>' . "\n";
		$return .= '<button type="submit" class="btn btn-primary">' . $button . '</button>' . "\n";
		$return .= Form::close() . "\n";
		$return .= '</div></div><!-- /.modal-content --></div><!-- /.modal-dialog -->' . "\n";
		$return .= '</div><!-- /.modal -->' . "\n";

	return $return;
	}

}
