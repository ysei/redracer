<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.                                   |
// | Copyright (c) 2005-2008 the Agavi Project.                                |
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
 * Manages Phing-based event dispatchers.
 *
 * @package    agavi
 * @subpackage build
 *
 * @author     Noah Fontes <noah.fontes@bitextender.com>
 * @copyright  Authors
 * @copyright  The Agavi Project
 *
 * @since      1.0.0
 *
 * @version    $Id: AgaviPhingEventDispatcherManager.class.php 2596 2008-07-09 10:15:10Z impl $
 */
final class AgaviPhingEventDispatcherManager
{
	protected static $dispatchers;
	
	/**
	 * Retrieves a dispatcher for a project.
	 *
	 * @param      Project The project that governs the dispatcher.
	 *
	 * @return     AgaviPhingEventDispatcher The dispatcher.
	 */
	public static function get(Project $project)
	{
		$hash = spl_object_hash($project);
		
		if(!isset(self::$dispatchers[$hash])) {
			self::$dispatchers[$hash] = new AgaviPhingEventDispatcher($project);
		}
		
		return self::$dispatchers[$hash];
	}
	
	/**
	 * Removes a dispatcher.
	 *
	 * @param      Project The project that governs the dispatcher.
	 *
	 * @return     boolean True if the dispatcher is successfully removed, false
	 *                     otherwise.
	 */
	public static function remove(Project $project)
	{
		$hash = spl_object_hash($project);
		
		if(isset(self::$dispatchers[$hash])) {
			unset(self::$dispatchers[$hash]);
			return true;
		}
		
		return false;
	}
}

?>