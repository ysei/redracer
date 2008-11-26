<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseDownload extends RedRacerDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('downloads');
    $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('selected', 'boolean', null, array('type' => 'boolean', 'unsigned' => true, 'notnull' => true, 'default' => 0));
    $this->hasColumn('dependency_id', 'boolean', null, array('type' => 'boolean', 'unsigned' => true));
    $this->hasColumn('user_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('file_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('release_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('resource_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));


    $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('File as file', array('local' => 'file_id',
                                        'foreign' => 'id',
                                        'onDelete' => 'CASCADE'));

    $this->hasOne('Release as release', array('local' => 'release_id',
                                              'foreign' => 'id',
                                              'onDelete' => 'CASCADE'));

    $this->hasOne('Resource as resource', array('local' => 'resource_id',
                                                'foreign' => 'id',
                                                'onDelete' => 'CASCADE'));

    $this->hasOne('User as user', array('local' => 'user_id',
                                        'foreign' => 'id',
                                        'onDelete' => 'CASCADE'));

    $timestampable0 = new Doctrine_Template_Timestampable();
    $this->actAs($timestampable0);
  }
}