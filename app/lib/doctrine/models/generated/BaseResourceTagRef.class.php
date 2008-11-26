<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseResourceTagRef extends RedRacerDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('resource_tag_ref');
    $this->hasColumn('resource_id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('tag_id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'unsigned' => true, 'length' => '4'));


    $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('Resource as resource', array('local' => 'resource_id',
                                                'foreign' => 'id',
                                                'onDelete' => 'CASCADE'));

    $this->hasOne('Tag as tag', array('local' => 'tag_id',
                                      'foreign' => 'id',
                                      'onDelete' => 'CASCADE'));
  }
}