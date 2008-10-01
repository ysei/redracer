<?php

/**
 * OurBaseAction
 *
 * This is the base action all your application's actions should extend.
 * This way, you can easily inject new functionality into all of your actions.
 *
 * @package    our
 *
 * @copyright  Harald Kirschner <mail@digitarald.de>
 */
class OurBaseAction extends AgaviAction
{

	/**
	 * @var		AgaviWebRequest
	 */
	protected $rq = null;

	/**
	 * @var		AgaviWebRouting
	 */
	protected $rt = null;


	/**
	 * @var		AgaviController
	 */
	protected $ct = null;

	/**
	 * @var		OurUser
	 */
	protected $us = null;

	/**
	 * @var		AgaviValidationManager
	 */
	protected $vm = null;

	/**
	 * @var		Doctrine_Connection
	 */
	protected $cn = null;

	/**
	 * @var		boolean
	 */
	protected $isSlot = false;

	/**
	 * Initialize this action.
	 *
	 * @param		AgaviContext The current application context.
	 *
	 * @return		bool true, if initialization completes successfully, otherwise false.
	 */
	public function initialize($context)
	{
		parent::initialize($context);

		$this->rq = $this->context->getRequest();
		$this->rt = $this->context->getRouting();
		$this->ct = $this->context->getController();
		$this->us = $this->context->getUser();
		$this->cn = $this->context->getDatabaseConnection();

		$this->vm = $this->container->getValidationManager();

		$this->isSlot = $this->container->hasParameter('is_slot');

		return true;
	}

}

?>