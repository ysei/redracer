<?php


class DependencyModel extends OurDoctrineModel
{

	public function setTableDefinition()
	{
		$this->setTableName('dependencies');

		$this->hasColumn('user_id', 'integer', 6, array(
			'unsigned'	=> true,
			'notnull'	=> true
		) );
		$this->hasColumn('resource_id', 'integer', 6, array(
			'unsigned'	=> true
		) );

		$this->hasColumn('paths', 'string', 255);

		$this->hasColumn('version', 'string', 16);
		$this->hasColumn('version_max', 'string', 16);

		$this->hasColumn('url', 'string', 255);
		$this->hasColumn('text', 'string', 500);
	}

	public function setUp()
	{
		$this->actAs('Timestampable');

		$this->index('user_id', array('fields' => 'user_id') );
		$this->hasOne('UserModel as user', array(
			'local'		=> 'user_id',
			'foreign'	=> 'id',
			'onDelete'	=> 'CASCADE'
		) );

		$this->index('resource_id', array('fields' => 'resource_id') );
		$this->hasOne('ResourceModel as resource', array(
			'local'		=> 'resource_id',
			'foreign'	=> 'id',
			'onDelete'	=> 'CASCADE'
		) );
	}

	public function toArray($deep = true, $prefixKey = false)
	{
		$ret = parent::toArray($deep, $prefixKey);

		$ret['url_edit'] = $this->context->getRouting()->gen('hub.resource.dependency.edit', array(
			'ident'	=> $this['resource']['ident'],
			'id'	=> $ret['id']
		) );

		return $ret;
	}

}

?>