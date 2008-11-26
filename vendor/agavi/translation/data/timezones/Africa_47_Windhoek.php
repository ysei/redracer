<?php

/**
 * Data file for Africa/Windhoek timezone, compiled from the olson data.
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
 * @version    $Id: Africa_47_Windhoek.php 3274 2008-11-04 10:10:58Z david $
 */

return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => 5400,
      'dstOffset' => 0,
      'name' => 'SWAT',
    ),
    1 => 
    array (
      'rawOffset' => 7200,
      'dstOffset' => 0,
      'name' => 'SAST',
    ),
    2 => 
    array (
      'rawOffset' => 7200,
      'dstOffset' => 3600,
      'name' => 'SAST',
    ),
    3 => 
    array (
      'rawOffset' => 7200,
      'dstOffset' => 0,
      'name' => 'CAT',
    ),
    4 => 
    array (
      'rawOffset' => 3600,
      'dstOffset' => 0,
      'name' => 'WAT',
    ),
    5 => 
    array (
      'rawOffset' => 3600,
      'dstOffset' => 3600,
      'name' => 'WAST',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -2458170504,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => -2109288600,
      'type' => 1,
    ),
    2 => 
    array (
      'time' => -860976000,
      'type' => 2,
    ),
    3 => 
    array (
      'time' => -845254800,
      'type' => 1,
    ),
    4 => 
    array (
      'time' => 637970400,
      'type' => 3,
    ),
    5 => 
    array (
      'time' => 765324000,
      'type' => 4,
    ),
    6 => 
    array (
      'time' => 778640400,
      'type' => 5,
    ),
    7 => 
    array (
      'time' => 796780800,
      'type' => 4,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'dynamic',
    'offset' => 3600,
    'name' => 'WA%sT',
    'save' => 3600,
    'start' => 
    array (
      'month' => 8,
      'date' => '1',
      'day_of_week' => -1,
      'time' => 7200000,
      'type' => 0,
    ),
    'end' => 
    array (
      'month' => 3,
      'date' => '1',
      'day_of_week' => -1,
      'time' => 7200000,
      'type' => 0,
    ),
    'startYear' => 1995,
  ),
  'name' => 'Africa/Windhoek',
);

?>