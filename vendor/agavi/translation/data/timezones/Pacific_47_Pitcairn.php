<?php

/**
 * Data file for Pacific/Pitcairn timezone, compiled from the olson data.
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
 * @version    $Id: Pacific_47_Pitcairn.php 3274 2008-11-04 10:10:58Z david $
 */

return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => -30600,
      'dstOffset' => 0,
      'name' => 'PNT',
    ),
    1 => 
    array (
      'rawOffset' => -28800,
      'dstOffset' => 0,
      'name' => 'PST',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -2177421580,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => 893665800,
      'type' => 1,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'static',
    'name' => 'PST',
    'offset' => -28800,
    'startYear' => 1999,
  ),
  'name' => 'Pacific/Pitcairn',
);

?>