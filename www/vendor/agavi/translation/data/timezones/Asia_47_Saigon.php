<?php

/**
 * Data file for Asia/Saigon timezone, compiled from the olson data.
 *
 * Auto-generated by the phing olson task on 03/15/2008 17:07:52
 *
 * @package    agavi
 * @subpackage translation
 *
 * @copyright  Authors
 * @copyright  The Agavi Project
 *
 * @since      0.11.0
 *
 * @version    $Id: Asia_47_Saigon.php 2367 2008-03-15 17:12:46Z david $
 */

return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => 25580,
      'dstOffset' => 0,
      'name' => 'SMT',
    ),
    1 => 
    array (
      'rawOffset' => 25200,
      'dstOffset' => 0,
      'name' => 'ICT',
    ),
    2 => 
    array (
      'rawOffset' => 28800,
      'dstOffset' => 0,
      'name' => 'ICT',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -2005974400,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => -1855983920,
      'type' => 1,
    ),
    2 => 
    array (
      'time' => -1819954800,
      'type' => 2,
    ),
    3 => 
    array (
      'time' => -1220428800,
      'type' => 1,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'static',
    'name' => 'ICT',
    'offset' => 25200,
    'startYear' => 1932,
  ),
  'name' => 'Asia/Saigon',
);

?>