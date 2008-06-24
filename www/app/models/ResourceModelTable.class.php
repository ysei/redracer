<?php


class ResourceModelTable extends OurDoctrineTable
{

	public function findOneById($id)
	{
		$query = $this->getQuery();

		$query->where('resource.id = ?', array($id) );

		return $query->fetchOne();
	}

	public function findOneByIdent($ident)
	{
		$query = $this->getQuery();

		$query->where('resource.ident = ?', array($ident) );

		return $query->fetchOne();
	}

	public function findByType($type)
	{
		$query = $this->getQuery();

		$query->where('resource.type = ?', array($type) );

		return $query->fetchOne();
	}

	/**
	 * Create query with from statement.
	 *
	 * @return		Doctrine_Query
	 */
	public function getQuery()
	{
		$query = parent::getQuery();

		$query->leftJoin('resource.bookmark WITH resource.type = ' . BookmarkModel::TYPE_ID);

		return $query;
	}

}

?>