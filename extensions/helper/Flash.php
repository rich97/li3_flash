<?php

/**
 * li3_flash plugin for Lithium. Copied and renamed from li3_flash_message.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
namespace li3_flash\extensions\helper;

/**
 * Helper to output flash messages.
 *
 * @see li3_flash_message\extensions\action\FlashMessage
 */
class Flash extends \lithium\template\Helper {

	/**
	 * Holds the instance of the flash message storage class
	 *
	 * @see \li3_flash_message\extensions\storage\FlashMessage
	 */
	protected $_classes = array(
		'storage' => '\li3_flash\extensions\storage\Flash'
	);

	/**
	 * Outputs a flash message using a template. The message will be cleared afterwards.
	 * With defaults settings it looks for the template
	 * `app/views/elements/flash_message.html.php`. If it doesn't exist, the  plugin's view
	 * at `li3_flash_message/views/elements/flash_message.html.php` will be used. Use this
	 * file as a starting point for your own flash message element. In order to use a
	 * different template, adjust `$options['type']` and `$options['template']` to your needs.
	 *
	 * @param string [$key] Optional message key.
	 * @param array [$options] Optional options.
	 *              - type: Template type that will be rendered.
	 *              - template: Name of the template that will be rendered.
	 *              - data: Additional data for the template.
	 *              - options: Additional options that will be passed to the renderer.
	 * @return string Returns the rendered template.
	 */
	public function output($key = 'default', array $options = array()) {
		$defaults = array(
			'type' => 'element',
			'template' => 'flash',
			'data' => array(),
			'options' => array()
		);
		$options += $defaults;

		$storage = $this->_classes['storage'];
		$view = $this->_context->view();
		$output = '';
		$type = array($options['type'] => $options['template']);
		$flash = $storage::read($key);

		if (!empty($flash)) {
			$data = $options['data'] + array('message' => $flash['message']) + $flash['atts'];
			$storage::clear($key);

			try {
                $request = $this->_context->_config['request'];
                if (!empty($request->params['library'])) {
                    $options['options'] += array('library' => $request->params['library']);
                }

				$output = $view->render($type, $data, $options['options']);
            } catch (\Exception $e) {
				$output = $view->render($type, $data, array('library' => 'li3_flash'));
			}
		}
		return $output;
	}

}

?>
