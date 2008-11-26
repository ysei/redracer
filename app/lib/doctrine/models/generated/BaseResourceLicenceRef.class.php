<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseResourceLicenceRef extends RedRacerDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('resource_licence_ref');
    $this->hasColumn('resource_id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('licence_id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'unsigned' => true, 'length' => '4'));


    $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

    $this->option('collate', 'utf8_unicode_ci');
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    $this->hasOne('Resource as resource', array('local' => 'resource_id',
                                                'foreign' => 'id',
                                                'onDelete' => 'CASCADE'));

    $this->hasOne('Licence as licence', array('local' => 'licence_id',
                                              'foreign' => 'id',
                                              'onDelete' => 'CASCADE'));
  }
}