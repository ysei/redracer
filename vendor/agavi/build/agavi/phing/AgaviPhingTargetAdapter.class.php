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
 * Implements a default adapter for listening for target events.
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
 * @version    $Id: AgaviPhingTargetAdapter.class.php 2596 2008-07-09 10:15:10Z impl $
 */
class AgaviPhingTargetAdapter implements AgaviIPhingTargetListener
{
	/**
	 * Invoked when a target is entered.
	 *
	 * @param      AgaviPhingTargetEvent The raised event.
	 */
	public function targetEntered(AgaviPhingTargetEvent $event)
	{
		
	}
	
	/**
	 * Invoked when a target is left.
	 *
	 * @param      AgaviPhingTargetEvent The raised event.
	 */
	public function targetLeft(AgaviPhingTargetEvent $event)
	{
		
	}
}

?>