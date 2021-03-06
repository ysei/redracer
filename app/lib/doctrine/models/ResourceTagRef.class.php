<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ResourceTagRef extends BaseResourceTagRef
{
	/**
	 * @param 	Doctrine_Event
	 */
	public function postInsert($event)
	{
		$query = Doctrine_Query::create();
		$query->update('Tag')
			->set('resources_count', 'resources_count + 1')
			->where('id = ?', array($this['tag_id']) )
			->execute();
	}

	/**
	 * @param 	Doctrine_Event
	 */
	public function postDelete($event)
	{
		$query = Doctrine_Query::create();
		$query->update('Tag')
			->set('resources_count', 'resources_count - 1')
			->where('id = ?', array($this['tag_id']) )
			->execute();
	}
}