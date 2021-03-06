<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Tag extends BaseTag
{
	/**
	 * toArray
	 *
	 * @param      boolean $deep - Return also the relations
	 * @return     array
	 */
	public function toArray($deep = false, $prefixKey = false)
	{
		$ret = parent::toArray(false, $prefixKey);

		$ret['url_resources'] = $this->getUrlResources();

		return $ret;
	}

	/**
	 * getUrlResources
	 *
	 * @return     string
	 */
	public function getUrlResources() {
		return $this->getContext()->getRouting()->gen('resources.index', array(
			'tags' => $this['word']
		) );
	}

}