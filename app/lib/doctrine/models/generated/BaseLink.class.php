<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseLink extends RedRacerDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('links');
    $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('user_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('resource_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'notnull' => true, 'length' => '4'));
    $this->hasColumn('flag', 'integer', 3, array('type' => 'integer', 'unsigned' => true, 'notnull' => true, 'default' => 0, 'length' => '3'));
    $this->hasColumn('title', 'string', 50, array('type' => 'string', 'length' => '50'));
    $this->hasColumn('description', 'string', 500, array('type' => 'string', 'length' => '500'));
    $this->hasColumn('url', 'string', 250, array('type' => 'string', 'length' => '250'));


    $this->index('flag_idx', array('fields' => 'flag'));

    $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('User as user', array('local' => 'user_id',
                                        'foreign' => 'id',
                                        'onDelete' => 'SET NULL'));

    $this->hasOne('Resource as resource', array('local' => 'resource_id',
                                                'foreign' => 'id',
                                                'onDelete' => 'CASCADE'));

    $this->hasMany('Diary as events', array('local' => 'id',
                                            'foreign' => 'link_id'));

    $timestampable0 = new Doctrine_Template_Timestampable();
    $this->actAs($timestampable0);
  }
}