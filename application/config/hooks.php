<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
/*
$hook['pre_system'] = array(
    'class'    => '',
    'function' => 'prettyurls',
    'filename' => 'prettyurls.php',
    'filepath' => 'hooks',
    'params'   => array()
);
*/

/**
 * Comment By Khuyenpv on 30.07.2015
 * Don't use hook configuration of the old version 
 *
$hook['post_controller_constructor'][] = array(
                                'class'    => '',
                                'function' => 'redirect_mobile',
                                'filename' => 'traceip.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

$hook['post_controller_constructor'][] = array(
                                'class'    => '',
                                'function' => 'trace_client_ip',
                                'filename' => 'traceip.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );
                             
$hook['cache_override'] = array(
                                'class'    => '',
                                'function' => 'display_cache_override',
                                'filename' => 'traceip.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

$hook['post_controller'] = array(
                                'class'    => '',
                                'function' => 'set_departure_date',
                                'filename' => 'traceip.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

*/

/**
 * NEW Hook Configuration for Bestprice Inbound 2015
 */
$hook['post_controller_constructor'][] = array(
		'class'    => 'extend_core',
		'function' => 'custom_cache_override',
		'filename' => 'extend_core.php',
		'filepath' => 'hooks',
		'params'   => array()
);

$hook['cache_override'] = array(
		'class'    => 'extend_core',
		'function' => 'display_cache_override',
		'filename' => 'extend_core.php',
		'filepath' => 'hooks',
		'params'   => array()
);

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */