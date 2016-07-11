<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Update I18n Data for the origin data
 * @param $origin_data: the origin data 
 * @param $table_cnf: array of [col_id_name, table_name]
 * @param $colum_cnf: array of [table_name, col_name_db, col_name_alias] 
 * 
 */
function update_i18n_data($origin_data, $get_mode, $table_cnf, $colum_cnf = ''){
	
	$CI =& get_instance();
	
	$CI->load->model('I18nModel');
	
	$language = lang_code();
	
	$origin_data = $get_mode == I18N_MULTIPLE_MODE ? $origin_data : array($origin_data);
	
	if($language == 'en') return  $get_mode == I18N_MULTIPLE_MODE ? $origin_data : $origin_data[0]; // don't need to load I18n Data for English version
	
	if(!empty($table_cnf) && !empty($origin_data)){
		
		foreach ($table_cnf as $tbl_cnf){
			
			$col_id_name = $tbl_cnf['col_id_name']; //default 
			
			$table_name = $tbl_cnf['table_name'];
			
			$record_ids = get_record_ids($origin_data, $col_id_name);
			
			$i18n_data = $CI->I18nModel->load_i18n_data($language, $table_name, $record_ids);
			
			foreach ($origin_data as $org_key => $obj_data){
				
				$obj_data = set_18n_data($obj_data, $i18n_data, $table_name, $col_id_name, $colum_cnf);
				
				$origin_data[$org_key] = $obj_data;
			}
		}
	}
	
	return $get_mode == I18N_MULTIPLE_MODE ? $origin_data : $origin_data[0];
}

/**
 * Khuyenpv 16.10.2014
 * Get record ids
 */
function get_record_ids($origin_data, $col_id_name){
	
	$ret = array();
	
	if(!empty($origin_data)){
		
		foreach ($origin_data as $value){
				
			if(isset($value[$col_id_name])) $ret[] = $value[$col_id_name];
			
		}
	}
	
	return $ret;
}

/**
 * Khuyenpv 16.10.2014
 * Set 18n data for an object
 */
function set_18n_data($obj_data, $i18n_data, $table_name, $col_id_name, $colum_cnf){
	
	if(!empty($i18n_data)){
		
		foreach ($i18n_data as $i18n){
			
			$field_name = $i18n['field_name'];
			
			$field_value = $i18n['field_value'];
			
			$record_id = $i18n['record_id'];
			
			if($record_id == $obj_data[$col_id_name] && !empty($field_value)){
				
				if (!empty($colum_cnf)){
					foreach ($colum_cnf as $cnf){
						
						if($table_name == $cnf['table_name'] && $field_name == $cnf['col_name_db'] && isset($cnf['col_name_alias'])){
							
							$field_name = $cnf['col_name_alias'];
							
							break;
						}
						
					}
				}
				
				if(isset($obj_data[$field_name])) $obj_data[$field_name] = $field_value;
				
			}
			
		}
		
	}
	
	return $obj_data;
}

