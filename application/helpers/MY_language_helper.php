<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function lang($line, $id = '')
 {
  $CI =& get_instance();
  $line = $CI->lang->line($line);

  $args = func_get_args();

  if(is_array($args)) array_shift($args);

  if(is_array($args) && count($args))
  {
      foreach($args as $arg)
      {
          $line = str_replace_first('%s', $arg, $line);
      }
  }

  if ($id != '')
  {
   //$line = '<label for="'.$id.'">'.$line."</label>";
  }

  return $line;
 }

 function str_replace_first($search_for, $replace_with, $in)
 {
     $pos = strpos($in, $search_for);
     if($pos === false)
     {
         return $in;
     }
     else
     {
         return substr($in, 0, $pos) . $replace_with . substr($in, $pos + strlen($search_for), strlen($in));
     }
 }
 
 /**
  * Khuyenpv 14.10.2014
  * Get the current used code
  */
 function lang_code(){
 
 	$CI =& get_instance();
 	
 	$lang_code = $CI->lang->lang_code();
 	
 	return $lang_code;
 }
 
 /**
  * Khuyenpv 14.10.2014
  * Get the current lang id
  */
 function lang_id(){
 
 	$CI =& get_instance();
 
 	$lang_id = $CI->lang->lang_id();
 
 	return $lang_id;
 }

/* End of file MY_language_helper.php */
/* Location: ./application/helpers/MY_language_helper */