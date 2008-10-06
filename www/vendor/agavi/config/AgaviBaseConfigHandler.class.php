<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.                                   |
// | Copyright (c) 2005-2008 the Agavi Project.                                |
// | Based on the Mojavi3 MVC Framework, Copyright (c) 2003-2005 Sean Kerr.    |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the    |
// | LICENSE file online at http://www.agavi.org/LICENSE.txt                   |
// |   vi: set noexpandtab:                                                    |
// |   Local Variables:                                                        |
// |   indent-tabs-mode: t                                                     |
// |   End:                                                                    |
// +---------------------------------------------------------------------------+

/**
 * AgaviBaseConfigHandler allows a developer to create a custom formatted
 * configuration file pertaining to any information they like and still
 * have it auto-generate PHP code.
 *
 * @package    agavi
 * @subpackage config
 *
 * @author     Sean Kerr <skerr@mojavi.org>
 * @author     Dominik del Bondio <ddb@bitxtender.com>
 * @author     David Zülke <dz@bitxtender.com>
 * @copyright  Authors
 * @copyright  The Agavi Project
 *
 * @since      0.11.0
 *
 * @version    $Id: AgaviBaseConfigHandler.class.php 2648 2008-08-09 17:09:55Z david $
 */
abstract class AgaviBaseConfigHandler extends AgaviParameterHolder
{
	/**
	 * Generate the code for returning from execute().
	 *
	 * @param      mixed A string with the code, or an array of code lines.
	 *
	 * @return     string PHP code.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	protected function generate($code)
	{
		if(is_array($code)) {
			$code = implode("\n", $code);
		}
		
		return sprintf(
			"<?php\n\n// This is a compiled Agavi configuration file\n// Generated by: %s\n// Date: %s\n\n%s\n\n?>",
			get_class($this),
			gmdate(DATE_ISO8601),
			$code
		);
	}
	
	/**
	 * Literalize a string value.
	 *
	 * @param      string The value to literalize.
	 *
	 * @return     string A literalized value.
	 *
	 * @deprecated Use AgaviToolkit::expandDirectives() instead.
	 *
	 * @author     Sean Kerr <skerr@mojavi.org>
	 * @author     Dominik del Bondio <ddb@bitxtender.com>
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      0.9.0
	 */
	public static function literalize($value)
	{
		return AgaviToolkit::literalize($value);
	}

	/**
	 * Replace configuration directive identifiers in a string.
	 *
	 * @param      string The value on which to run the replacement procedure.
	 *
	 * @return     string The new value.
	 *
	 * @deprecated Use AgaviToolkit::expandDirectives() instead.
	 *
	 * @author     Sean Kerr <skerr@mojavi.org>
	 * @author     Johan Mjones <johan.mjones@ongame.com>
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      0.9.0
	 */
	public static function replaceConstants($value)
	{
		return AgaviToolkit::expandDirectives($value);
	}

	/**
	 * Replace a relative filesystem path with an absolute one.
	 *
	 * @param      string A relative filesystem path.
	 *
	 * @return     string The new path.
	 *
	 * @author     Sean Kerr <skerr@mojavi.org>
	 * @since      0.9.0
	 */
	public static function replacePath($path)
	{
		if(!AgaviToolkit::isPathAbsolute($path)) {
			// not an absolute path so we'll prepend to it
			$path = AgaviConfig::get('core.app_dir') . '/' . $path;
		}

		return $path;
	}
}

?>