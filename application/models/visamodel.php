<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Visa Model
 *
 * @author toanlk
 * @since  May 12, 2015
 */
class VisaModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }

    /**
     * Get all tour categories.
     */
    function getAllNationalities($voa_accepted = false)
    {
        $this->db->select('id, name, voa_accepted, visa_group_id, embassy_address, name as url_title');
        
        $this->db->order_by('name', 'asc');
        
        $this->db->where('deleted !=', DELETED);
        
        if ($voa_accepted)
        {
            $this->db->where('voa_accepted', 1);
        }
        
        $query = $this->db->get('nationalities');
        
        $nationalities = $query->result_array();
        
        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'nationalities');
        $nationalities = update_i18n_data($nationalities, I18N_MULTIPLE_MODE, $table_cnf);
        
        return $nationalities;
    }

    /**
     * get_visa_rates
     *
     * Get visa fee by nationality
     *
     * @author toanlk
     * @since  Nov 17, 2014
     */
    function get_visa_rates($nationalities, $numb_visa, $visa_type)
    {
        $visa_rates = array(
            'rate' => lang('label_visa_na'),
            'discount' => 0
        );
        
        $this->db->select('vpd.price,vp.urgent_price,vp.discount');
        
        $this->db->from('visa_price_details as vpd');
        
        $this->db->join('visa_price as vp', 'vp.id = vpd.visa_price_id');
        
        if (is_array($nationalities))
        {
            $this->db->where_in('vp.nationality_id', $nationalities);
        }
        else
        {
            $this->db->where('vp.nationality_id', $nationalities);
        }
        
        $this->db->where('vpd.quantity', $numb_visa);
        $this->db->where('vpd.visa_type', $visa_type);
        
        $query = $this->db->get();
        
        $rates = $query->result_array();
        
        if (count($rates) > 0)
        {
            if (is_array($nationalities))
            {
                foreach ($rates as $value)
                {
                    $visa_rates[] = array(
                        'price' => $value['price'],
                        'discount' => $value['discount'],
                        'urgent_price' => $value['urgent_price']
                    );
                }
            } else {
                $visa_rates = array(
                    'price' => $rates[0]['price'],
                    'discount' => $rates[0]['discount'],
                    'urgent_price' => $rates[0]['urgent_price']
                );
            }
            
        }
        
        return $visa_rates;
    }

    function getVisaRatesTable()
    {
        $visa_types = $this->config->item("visa_types");
        
        $rates_table = array();
        
        foreach ($visa_types as $key => $type)
        {
            $this->db->select('vpd.price,vp.urgent_price,vpd.quantity,vp.discount');
            $this->db->from('visa_price_details as vpd');
            $this->db->join('visa_price as vp', 'vp.id = vpd.visa_price_id');
            
            $this->db->where('vp.nationality_id', 6);
            // $this->db->where('vpd.quantity', $numb_visa);
            $this->db->where('vpd.visa_type', $key);
            
            // $this->db->order_by('vp.nationality_id', 'asc');
            $this->db->order_by('vpd.quantity', 'asc');
            
            $this->db->limit(10);
            
            $query = $this->db->get();
            
            $rates = $query->result_array();
            
            $rates_table[$key] = $rates;
        }
        
        return $rates_table;
    }

    function get_visa_group_price()
    {
        $visa_types = $this->config->item("visa_types");
        
        // get visa group
        $this->db->select('id');
        $this->db->where('id !=', 2); // exemption country
        $query = $this->db->get('visa_group');
        
        $visa_group = $query->result_array();
        
        foreach ($visa_group as $k => $group)
        {
            // get nationalities
            $this->db->select('id');
            $this->db->where('visa_group_id =', $group['id']);
            $query = $this->db->get('nationalities');
            
            $nationalities = $query->result_array();
            
            foreach ($nationalities as $nat)
            {
                $group['country'][] = $nat['id'];
            }
            
            if (! empty($nationalities))
            {
                
                $rates_table = array();
                
                foreach ($visa_types as $key => $type)
                {
                    $this->db->select('vpd.price, vp.urgent_price, vpd.quantity, vp.discount');
                    $this->db->from('visa_price_details as vpd');
                    $this->db->join('visa_price as vp', 'vp.id = vpd.visa_price_id');
                    
                    $this->db->where('vp.nationality_id', $nationalities[0]['id']);
                    // $this->db->where('vpd.quantity', $numb_visa);
                    $this->db->where('vpd.visa_type', $key);
                    
                    // $this->db->order_by('vp.nationality_id', 'asc');
                    $this->db->order_by('vpd.quantity', 'asc');
                    
                    $this->db->limit(10);
                    
                    $query = $this->db->get();
                    
                    $rates = $query->result_array();
                    
                    $rates_table[$key] = $rates;
                }
                
                $group['price'] = $rates_table;
            }
            
            $visa_group[$k] = $group;
        }
        
        return $visa_group;
    }

    function existNationality($name)
    {
        $this->db->select('nat.*,vg.description as group_description');
        $this->db->like('nat.name', $name);
        
        $this->db->join('visa_group as vg', 'vg.id = nat.visa_group_id', 'left');
        $query = $this->db->get('nationalities nat');
        
        $results = $query->result_array();
        
        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'nationalities');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);
        
        if (count($results) > 0)
        {
            return $results[0];
        }
        
        return null;
    }
    
    // get the min visa discount value, show in booking together
    function get_min_visa_discount()
    {
        $this->db->select_min('discount');
        
        $this->db->where('discount >', 0);
        
        $this->db->where('deleted !=', DELETED);
        
        $query = $this->db->get('visa_price');
        
        $results = $query->result_array();
        
        if (count($results) > 0)
        {
            
            return $results[0]['discount'];
        }
        
        return 0;
    }
}

?>