<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Visa_Guides
 *
 * @author toanlk
 * @since  May 12, 2015
 */
class Visa_Guides extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('Visa_Model', 'Faq_Model', 'FaqModel'));

        $this->load->language('visa');

        $this->load->helper(array('basic', 'resource', 'visa', 'recommend'));

        // $this->output->enable_profiler(TRUE);
    }

    function index()
    {
        $data = $this->_get_common_data();

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_FEES_PAGE);

        $data['page_theme'] = get_page_theme(VN_VISA_FEES_PAGE, $data['is_mobile']);

        $data = $this->_get_rate_table($data);

        // visa on arrival accepted countries
        $data['voa_countries'] = get_voa_countries($data['countries']);

        if ($data['is_mobile'])
        {
            $data['top_visa_questions'] = $this->load->view('mobile/vietnam_visa/common/top_visa_questions', $data, TRUE);
            
            render_view('vietnam_visa/questions/visa_fees', $data, $data['is_mobile']);
        }
        else
        {
            $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_FEES_PAGE);

            $data = load_tripadvisor($data, $data['is_mobile']);

            $data['top_visa_questions'] = $this->load->view('visa/common/top_visa_questions', $data, TRUE);

            $data['why_apply'] = $this->load->view('vietnam_visa/common/why_apply', $data, TRUE);

            $data['main_view'] = $this->load->view('vietnam_visa/questions/visa_fees', $data, TRUE);

            render_view('vietnam_visa/questions/layout_view', $data);
        }
    }

    /**
     * visa_for_citizens
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function visa_for_citizens()
    {
        // get country name
        $url_title = $this->uri->segment(2);
        $url_title = str_replace(URL_SUFFIX, '', anti_sql($url_title));
        $str_name = trim(str_replace('-', ' ', str_replace('visa-for-', '', $url_title)));

        $country = $this->Visa_Model->get_country_by_name($str_name);

        // check exist
        if (empty($country))
        {
            redirect(site_url());
        }

        $data = $this->_get_common_data();

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_FOR_CITIZENS_PAGE, $country);

        $data['page_theme'] = get_page_theme(VN_VISA_FOR_CITIZENS_PAGE, $data['is_mobile']);

        $data = $this->_get_rate_table($data);

        // get common data
        $data['country'] = $country;

        if ($data['is_mobile'])
        {
            render_view('vietnam_visa/questions/visa_for_citizens', $data, $data['is_mobile']);
        }
        else
        {
            $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_FOR_CITIZENS_PAGE);

            $data = load_tripadvisor($data, $data['is_mobile']);
            
            $data['visa_apply_form'] = $this->load->view('vietnam_visa/home/visa_apply_form', $data, TRUE);

            $data['why_apply'] = $this->load->view('vietnam_visa/common/why_apply', $data, TRUE);

            $data['main_view'] = $this->load->view('vietnam_visa/questions/visa_for_citizens', $data, TRUE);

            render_view('vietnam_visa/questions/layout_view', $data);
        }
    }

    /**
     * visa_requirements
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function visa_requirements()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_REQUIREMENTS_PAGE, 'visa_requirements', $is_mobile);
    }

    /**
     * visa_application
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function visa_application()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_REQUIREMENTS_PAGE, 'visa_application', $is_mobile);
    }

    /**
     * visa_on_arrival
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function visa_on_arrival()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_ON_ARRIVAL_PAGE, 'visa_on_arrival', $is_mobile);
    }

    /**
     * how_to_apply
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function how_to_apply()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_HOW_TO_APPLY_PAGE, 'how_to_apply', $is_mobile);
    }

    /**
     * vietnam_visa_embassies
     *
     * @author TinVM
     * @since  May 18, 2015
     */
    function visa_embassies()
    {
        $is_mobile = is_mobile();

        $data['alphas'] = range('A', 'Z');

        $this->vietnam_visa_guides(VN_VISA_EMBASSIES_WORLDWIDE_PAGE, 'visa_embassies', $is_mobile, $data);
    }

    /**
     * vietnam_visa_availability
     *
     * @author TinVM
     * @since  May 18, 2015
     */
    function visa_availability()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_AVAILABILITY_FEE_PAGE, 'visa_information', $is_mobile);
    }

    /**
     * vietnam_visa_exemption
     *
     * @author TinVM
     * @since  May 18, 2015
     */
    function visa_exemption()
    {
        $is_mobile = is_mobile();

        $this->vietnam_visa_guides(VN_VISA_EXEMPTION_PAGE, 'visa_exemption', $is_mobile);
    }

    /**
     * vietnam_visa_types
     *
     * @author TinVM
     * @since  May 18, 2015
     */
    function visa_types()
    {
        $is_mobile = is_mobile();

        $faq = $this->Faq_Model->get_faq(71);

        if (! empty($faq))
        {
            $data['link_data'] = $faq['answer'];
        }

        $data = apply_canonical($data, VIETNAM_VISA);

        $this->vietnam_visa_guides(VN_VISA_TYPES_PAGE, 'visa_types', $is_mobile, $data);
    }


    /**
     * Vietnam Visa Guides
     *
     * @author TinVM
     * @since  May 18, 2015
     */
    function vietnam_visa_guides($page, $view_name, $is_mobile, $data = array())
    {
        $data = $this->_get_common_data($data);

        $data['is_mobile'] = $is_mobile;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta($page);

        $data['page_theme'] = get_page_theme($page, $data['is_mobile']);

        if ($data['is_mobile'])
        {
            $data['top_visa_questions'] = $this->load->view('mobile/vietnam_visa/common/top_visa_questions', $data, TRUE);
            
            render_view('vietnam_visa/questions/'. $view_name, $data, $data['is_mobile']);
        }
        else {
            $data = get_page_navigation($data, $data['is_mobile'], $page);

            $data = load_tripadvisor($data, $data['is_mobile']);
            
            $data['visa_apply_form'] = $this->load->view('vietnam_visa/home/visa_apply_form', $data, TRUE);

            $data['top_visa_questions'] = $this->load->view('vietnam_visa/common/top_visa_questions', $data, TRUE);
            
            $data['why_apply'] = $this->load->view('vietnam_visa/common/why_apply', $data, TRUE);

            $data['main_view'] = $this->load->view('vietnam_visa/questions/'. $view_name, $data, TRUE);

            render_view('vietnam_visa/questions/layout_view', $data);
        }
    }

    /**
     * _get_common_data
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function _get_common_data($data = array())
    {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        // set cache html
        set_cache_html();

        // set current menu
        set_current_menu(MNU_VN_VISA);

        $lstCountries = $this->Visa_Model->get_nationalities();

        $full_rates_table = $this->Visa_Model->get_visa_group_price();

        foreach ($lstCountries as $k => $country)
        {
            foreach ($full_rates_table as $val)
            {
                if (in_array($country['id'], $val['country']))
                {
                    $country['from_price'] = $val['price'][1][0]['price'];
                    break;
                }
            }

            $lstCountries[$k] = $country;
        }

        $data['countries'] = $lstCountries;

        $data['is_mobile'] = $is_mobile;

        $data['rush_services'] = $this->config->item("rush_services");

        $data['visa_stamp_fee'] = $this->config->item("visa_stamp_fee");

        $data['max_application'] = $this->config->item("max_application");

        $data['visa_types'] = $data['types'] = $this->config->item("visa_types");
        
        // visa on arrival accepted countries
        $data['voa_countries'] = get_voa_countries($data['countries']);

        return $data;
    }

    /**
     * _get_rate_table
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function _get_rate_table($data)
    {
        $lstCountries = $this->Visa_Model->get_nationalities();

        $rates_table = $this->Visa_Model->get_visa_group_price();

        foreach ($lstCountries as $k => $country)
        {
            foreach ($rates_table as $val)
            {
                if (in_array($country['id'], $val['country']))
                {
                    $country['from_price'] = $val['price'][1][0]['price'];
                    break;
                }
            }

            $lstCountries[$k] = $country;
        }

        $data['countries'] = $lstCountries;

        $visa_rates = null;

        if (! empty($data['country']['id']))
        {
            foreach ($rates_table as $val)
            {
                if (in_array($data['nationality_id'], $val['country']))
                {
                    $visa_rates = $val['price'];
                    break;
                }
            }
        }
        else
        {
            $visa_rates = $this->Visa_Model->get_rates_table();
        }

        $data['rates_table'] = $visa_rates;

        return $data;
    }

    function download()
    {
        $this->load->helper('download');

        $file_name = $this->uri->segment(4);

        $data = file_get_contents('./' . $this->config->item('visa_file_resource_path') . $file_name); // Read the file's contents

        $name = $file_name;

        force_download($name, $data);
    }
}
?>