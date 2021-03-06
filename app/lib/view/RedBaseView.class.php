<?php

/**
 * RedBaseView
 *
 * This is the base view all your application's views should extend.
 * This way, you can easily inject new functionality into all of your views.
 *
 * @package    redracer
 *
 * @copyright  Harald Kirschner <mail@digitarald.de>
 */
class RedBaseView extends AgaviView
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
	 * @var		AgaviWebResponse
	 */
	protected $rs = null;

	/**
	 * @var		RedUser
	 */
	protected $us = null;

	/**
	 * @var		Doctrine_Connection
	 */
	protected $cn = null;

	/**
	 * @var		boolean
	 */
	protected $isSlot = false;

	/**
	 * @see		AgaviView::initialize()
	 */
	public function initialize(AgaviExecutionContainer $container)
	{
		parent::initialize($container);

		$this->rq = $this->context->getRequest();
		$this->rt = $this->context->getRouting();
		$this->ct = $this->context->getController();
		$this->us = $this->context->getUser();
		$this->cn = $this->context->getDatabaseConnection();
		$this->rs = $this->getResponse();

		$this->isSlot = $this->container->hasParameter('is_slot');

		return true;
	}

	public final function execute(AgaviRequestDataHolder $rd)
	{
		throw new AgaviViewException(sprintf(
			'The View "%1$s" does not implement an "execute%3$s()" method to serve '.
			'the Output Type "%2$s", and the base View "%4$s" does not implement an '.
			'"execute%3$s()" method to handle this situation.',
			get_class($this),
			$this->container->getOutputType()->getName(),
			ucfirst(strtolower($this->container->getOutputType()->getName())),
			get_class()
		));
	}

	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		throw new AgaviViewException(sprintf(
			'The View "%1$s" does not implement an "execute%3$s()" method to serve '.
			'the Output Type "%2$s". It is recommended that you change the code of '.
			'the method "execute%3$s()" in the base View "%4$s" that is throwing '.
			'this exception to deal with this situation in a more appropriate '.
			'way, for example by forwarding to the default 404 error action, or by '.
			'showing some other meaningful error message to the user which explains '.
			'that the operation was unsuccessful beacuse the desired Output Type is '.
			'not implemented.',
			get_class($this),
			$this->container->getOutputType()->getName(),
			ucfirst(strtolower($this->container->getOutputType()->getName())),
			get_class()
		));
	}

	public function setupHtml(AgaviRequestDataHolder $rd, $layoutName = null)
	{
		$this->loadLayout($layoutName);

		if (!$layoutName) {
			// standard assets
			$this->rq->appendAttribute('scripts', '/js/lib/mootools.js', 'org.redracer.view');
			$this->rq->appendAttribute('scripts', '/js/lib/Element.AutoGrow.js', 'org.redracer.view');
			$this->rq->appendAttribute('scripts', '/js/base.js', 'org.redracer.view');

			$this->rq->appendAttribute('styles', '/css/base.css', 'org.redracer.view');

			// user profile
			$profile = $this->us->getProfile();
			if ($profile) {
				$profile = $profile->toArray(true);
			}
			$this->setAttributeByRef('user', $profile);
		}

		$this->generateFilters($rd);
	}

	/**
	 * @todo Extra slot for filter menu
	 */
	protected function generateFilters(AgaviRequestDataHolder $rd)
	{
		$filters = array('category' => array(), 'sort' => array(), 'tags' => array() );

		$peer = $this->context->getModel('Resources');
		$count = $peer->countByCategory();

		/**
		 * @todo Export possible categories and sortings into config!
		 */
		$rd_category = $rd->getParameter('category');
		$index = 0;
		$filters['category'] = array();
		foreach (array('project' => 'Projects', 'article' => 'Articles', 'snippet' => 'Snippets') as $category => $title)
		{
			$selected = ($rd_category == $category);
			$filters['category'][] = array(
				'selected' => $selected,
				'title' => $title,
				'url' => $this->rt->gen('resources.index', array('category' => ($selected) ? null : $category) ),
				'class' => ($selected) ? 'selected' : '',
				'count' => (isset($count[$index])) ? $count[$index] : 0
			);
			$index++;
		}

		$rd_sort = $rd->getParameter('sort', 'popular');
		foreach (array('popular' => 'Popular', 'recent' => 'Recent', 'rating' => 'Rating') as $sort => $title)
		{
			$selected = ($rd_sort == $sort);
			$filters['sort'][] = array(
				'selected' => $selected,
				'title' => $title,
				'url' => $this->rt->gen('resources.index', array('sort' => $sort) ),
				'class' => ($selected) ? 'selected' : ''
			);
		}

		$peer = $this->context->getModel('Tags');
		$tags = $peer->findByCount()->toArray();

		$filters['tag'] = array();
		$rd_tag = $rd->getParameter('tag');
		foreach ($tags as $tag)
		{
			$selected = ($rd_tag == $tag['word']);
			$filters['tag'][] = array(
				'selected' => $selected,
				'title' => $tag['word'],
				'count' => $tag['resources_count'],
				'url' => $tag['url_resources'],
				'class' => ($selected) ? 'selected' : ''
			);
		}

		$this->setAttributeByRef('filters', $filters);
	}

	/**
	 * Generate RSS
	 *
	 * Quick and dirty
	 *
	 * @param      array Channel items (title, description, etc)
	 * @param      array Items
	 */
	public function generateRSS(array $channel_items, array $items)
	{
		$doc = new DOMDocument();

		$doc->preserveWhiteSpace = true;

		$root = $doc->createElement('rss');
		$root->setAttribute('version', '2.0');
		$doc->appendChild($root);

		$channel = $doc->createElement('channel');
		$root->appendChild($channel);

		$channel_items['link'] = $this->rt->gen(null, array(), array(
			'relative' => true
		) );
		$channel_items['lastBuildDate'] = date('r');
		$channel_items['pubDate'] = date('r');
		$channel_items['language'] = 'en-gb';
		$channel_items['docs'] = 'http://blogs.law.harvard.edu/tech/rss';
		$channel_items['generator'] = 'digitarald.de';
		$channel_items['ttl'] = '60';

		foreach ($channel_items as $tag => $text)
		{
			$sub = $doc->createElement($tag);
			$sub->appendChild($doc->createTextNode($text) );
			$channel->appendChild($sub);
		}

		foreach ($items as $item)
		{
			$entries = array(
				'item' => $item['title'],
				'description' => $item['description'],
				'pubDate' => $item['date'],
				'link' => $item['link'],
				'guid' => $item['link']
			);

			foreach ($entries as $tag => $text)
			{
				$sub = $doc->createElement($tag);
				$sub->appendChild($doc->createTextNode($text) );
				$channel->appendChild($sub);
			}
		}

		return $doc->saveXML();
	}


	public function redirect($url)
	{
		$this->rs->setRedirect($url);

		return null;
	}


}

?>