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
 * Represents a listener for events involving build system tasks.
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
 * @version    $Id: AgaviIPhingTaskListener.interface.php 2596 2008-07-09 10:15:10Z impl $
 */
interface AgaviIPhingTaskListener extends AgaviIPhingListener
{
	/**
	 * Invoked when a task is entered.
	 *
	 * @param      AgaviPhingTaskEvent The raised event.
	 */
	public function taskEntered(AgaviPhingTaskEvent $event);
	
	/**
	 * Invoked when a task is left.
	 *
	 * @param      AgaviPhingTaskEvent The raised event.
	 */
	public function taskLeft(AgaviPhingTaskEvent $event);
}

?>