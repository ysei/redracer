<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseRelease extends RedRacerDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('releases');
    $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('user_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'length' => '4'));
    $this->hasColumn('resource_id', 'integer', 4, array('type' => 'integer', 'unsigned' => true, 'notnull' => true, 'length' => '4'));
    $this->hasColumn('version', 'string', 10, array('type' => 'string', 'notnull' => true, 'length' => '10'));
    $this->hasColumn('flag', 'integer', 3, array('type' => 'integer', 'unsigned' => true, 'notnull' => true, 'default' => 0, 'length' => '3'));
    $this->hasColumn('recommended', 'boolean', null, array('type' => 'boolean', 'unsigned' => true, 'notnull' => true, 'default' => 0));
    $this->hasColumn('hosted', 'boolean', null, array('type' => 'boolean', 'unsigned' => true, 'notnull' => true, 'default' => 0));
    $this->hasColumn('stability', 'integer', 1, array('type' => 'integer', 'unsigned' => true, 'notnull' => true, 'default' => 0, 'length' => '1'));
    $this->hasColumn('notes', 'string', 5000, array('type' => 'string', 'length' => '5000'));
    $this->hasColumn('changelog', 'string', 5000, array('type' => 'string', 'length' => '5000'));
    $this->hasColumn('url_source', 'string', 250, array('type' => 'string', 'length' => '250'));
    $this->hasColumn('url_download', 'string', 250, array('type' => 'string', 'length' => '250'));
    $this->hasColumn('url_notes', 'string', 250, array('type' => 'string', 'length' => '250'));
    $this->hasColumn('released_at', 'date', null, array('type' => 'date'));
    $this->hasColumn('imported_at', 'timestamp', null, array('type' => 'timestamp'));


    $this->index('version_idx', array('fields' => array(0 => 'resource_id', 1 => 'version')));
    $this->index('recommended_idx', array('fields' => 'recommended'));

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

    $this->hasMany('Dependency as dependencies', array('local' => 'id',
                                                       'foreign' => 'release_id'));

    $this->hasMany('Dependency as target_dependencies', array('local' => 'id',
                                                              'foreign' => 'target_release_id'));

    $this->hasMany('Download as downloads', array('local' => 'id',
                                                  'foreign' => 'release_id'));

    $this->hasMany('Diary as events', array('local' => 'id',
                                            'foreign' => 'release_id'));

    $this->hasMany('File as files', array('local' => 'id',
                                          'foreign' => 'release_id'));

    $timestampable0 = new Doctrine_Template_Timestampable();
    $this->actAs($timestampable0);
  }
}