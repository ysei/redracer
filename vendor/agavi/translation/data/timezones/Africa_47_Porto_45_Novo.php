<?php

/**
 * Data file for Africa/Porto-Novo timezone, compiled from the olson data.
 *
 * Auto-generated by the phing olson task on 11/04/2008 09:20:40
 *
 * @package    agavi
 * @subpackage translation
 *
 * @copyright  Authors
 * @copyright  The Agavi Project
 *
 * @since      0.11.0
 *
 * @version    $Id: Africa_47_Porto_45_Novo.php 3274 2008-11-04 10:10:58Z david $
 */

return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => 0,
      'dstOffset' => 0,
      'name' => 'GMT',
    ),
    1 => 
    array (
      'rawOffset' => 3600,
      'dstOffset' => 0,
      'name' => 'WAT',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -1830384628,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => -1131235200,
      'type' => 1,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'static',
    'name' => 'WAT',
    'offset' => 3600,
    'startYear' => 1935,
  ),
  'name' => 'Africa/Porto-Novo',
);

?>