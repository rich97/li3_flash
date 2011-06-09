<?php
/**
 * li3_flash_message plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
$class = (!empty($class)) ? $class : null;
$class = \lithium\util\Inflector::camelize($class);
?>
<div class="message<?= $class;  ?>">
	<?= $message; ?>
</div>
