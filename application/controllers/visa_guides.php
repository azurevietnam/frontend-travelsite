<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
  *  Visa Guides
  *
  *  @author toanlk
  *  @since  Oct 27, 2014
  */
class Visa_Guides extends CI_Controller
{
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('FaqModel', 'VisaModel', 'BookingModel'));
		$this->load->helper(array('form', 'tour', 'text', 'cookie', 'visa', 'group'));
		$this->load->language(array('faq','visa'));
		
		$this->load->driver('cache', array('adapter' => 'file'));
		
		// for test only
		// $this->output->enable_profiler(TRUE);
	}
	
	function index()
    {
        $data = $this->_setFormData(array());
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa_fees');
        
        $data['navigation'] = createVisaGuideNavLink('visa_fees');
        
        $data['countries'] = $this->VisaModel->getAllNationalities(true);
        
        $data['visa_fees'] = true;
        
        $min_visa_discount = $this->VisaModel->get_min_visa_discount();
        
        $data['min_visa_discount'] = $min_visa_discount;
        
        $data['check_rate_view'] = $this->load->view('visa/check_rate_view', $data, TRUE);
        
        $data['main_view'] = $this->load->view('visa/questions/visa_fees_view', $data, TRUE);
        
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function _setFormData($data)
    {
        // get faqs
        $data = get_visa_faqs($data);
        
        // highlight menu
        $this->session->set_userdata('MENU', MNU_VN_VISA);
        
        $lstCountries = $this->VisaModel->getAllNationalities();
        
        $full_rates_table = $this->VisaModel->get_visa_group_price();
        
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
        
        $visa_rates = null;
        
        if (! empty($data['nationality_id']))
        {
            
            $rates_table = $this->VisaModel->get_visa_group_price();
            
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
            $visa_rates = $this->VisaModel->getVisaRatesTable();
        }
        
        $data['rates_table'] = $visa_rates;
        
        // Get visa configuration
        
        $data['types'] = $this->config->item("visa_types");
        
        $data['rush_services'] = $this->config->item("rush_services");
        
        $data['visa_stamp_fee'] = $this->config->item("visa_stamp_fee");
        
        $data['max_application'] = $this->config->item("max_application");
        
        $data['visa_types'] = $this->config->item("visa_types");
        
        $data['apply_button'] = true;
        
        // Render view
        
        $data['why_apply'] = $this->load->view('visa/common/why_apply', $data, TRUE);
        
        $data['top_visa_questions'] = $this->load->view('visa/common/top_visa_questions', $data, TRUE);
        
        // CSS and JS
        $data = get_visa_theme($data);
        
        return $data;
    }

    function visa_requirements()
    {
        $data = array();
        $data = $this->_setFormData($data);
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa_requirements');
        $data['navigation'] = createVisaGuideNavLink('visa_requirements');
        
        $data['main_view'] = $this->load->view('visa/questions/visa_requirements', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function visa_application()
    {
        $data = array();
        $data = $this->_setFormData($data);
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa_application');
        $data['navigation'] = createVisaGuideNavLink('visa_application');
        
        $data['main_view'] = $this->load->view('visa/questions/visa_application', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function visa_for_citizens()
    {
        $url_title = $this->uri->segment(2);
        
        // anti sql injection
        $url_title = anti_sql($url_title);
        
        $url_title = str_replace(URL_SUFFIX, '', $url_title);
        $url_title = str_replace('visa-for-', '', $url_title);
        $nationality = trim(str_replace('-', ' ', $url_title));
        
        $nat = $this->VisaModel->existNationality($nationality);
        
        // check exist
        if (empty($nat))
        {
            redirect(site_url());
        }
        
        $data = array();
        $data['NO_APPLY_BUTTON'] = true;
        
        $nationality = $nat['name'];
        $data['nationality'] = $nationality;
        $data['nationality_id'] = $nat['id'];
        
        $data = $this->_setFormData($data);
        
        $data['nat'] = $nat;
        
        $data = get_booking_together_recommend($data);
        
        // set site meta and navigation
        $nav_text = lang_arg('visa_for_citizens_navigation', ucfirst($nationality));
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $metas['title'] = lang('lb_vietnam') . ' ' . $nav_text . ' - ' . BRANCH_NAME;
        $metas['keywords'] = strtolower($nav_text);
        $metas['description'] = lang_arg('visa_for_citizens_description', ucfirst($nationality));
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/visa_for_citizens', $data, TRUE);
        
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function visa_on_arrival()
    {
        $data = array();
        $data = $this->_setFormData($data);
        
        // set site meta and navigation
        $nav_text = lang('vietnam_visa_h1');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $faq = $this->FaqModel->getFaqQuestionByPage('vietnam-visa/visa-on-arrival.html');
        if (! empty($faq))
        {
            $data['link_data'] = $faq['answer'];
        }
        
        $data = apply_canonical($data, VIETNAM_VISA);
        
        $metas['title'] = lang('visa_on_arrival_page_title') . ' - ' . BRANCH_NAME;
        $metas['keywords'] = strtolower($nav_text);
        $metas['description'] = lang('visa_on_arrival_description');
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/visa_on_arrival', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function how_to_apply()
    {
        $data = $this->_setFormData(array());
        
        // set site meta and navigation
        $nav_text = lang('how_to_apply_navigation');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $metas['title'] = lang('how_to_apply_page_title') . ' - ' . BRANCH_NAME;
        $metas['description'] = lang('how_to_apply_page_title');
        $metas['keywords'] = strtolower($metas['description']);
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/how_to_apply', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function vietnam_embassies()
    {
        $data = $this->_setFormData(array());
        
        // set site meta and navigation
        $nav_text = lang('vietnam_embassies_page_title');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $metas['title'] = $nav_text . ' - ' . BRANCH_NAME;
        $metas['description'] = $nav_text;
        $metas['keywords'] = strtolower($metas['description']);
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['alphas'] = range('A', 'Z');
        
        $data['main_view'] = $this->load->view('visa/questions/vietnam_embassies', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function vietnam_visa_information()
    {
        $data = array();
        $data = $this->_setFormData($data);
        
        // set site meta and navigation
        $nav_text = lang('vietnam_visa_information_page_title');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $metas['title'] = $nav_text . ' - ' . BRANCH_NAME;
        $metas['description'] = $nav_text;
        $metas['keywords'] = strtolower($metas['description']);
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/vietnam_visa_information', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function vietnam_visa_exemption()
    {
        $data = array();
        $data = $this->_setFormData($data);
        
        // set site meta and navigation
        $nav_text = lang('vietnam_visa_exemption_page_title');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $metas['title'] = $nav_text . ' - ' . BRANCH_NAME;
        $metas['description'] = $nav_text;
        $metas['keywords'] = strtolower($metas['description']);
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/visa_exemption', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function vietnam_visa_types()
    {
        $data = $this->_setFormData(array());
        
        // set site meta and navigation
        $nav_text = lang('vietnam_visa_types_page_title');
        $data['navigation'] = createVisaGuideNavLink($nav_text, true);
        
        $faq = $this->FaqModel->getFaqQuestionByPage('vietnam-visa/visa-types.html');
        if (! empty($faq))
        {
            $data['link_data'] = $faq['answer'];
        }
        
        $data = apply_canonical($data, VIETNAM_VISA);
        
        $metas['title'] = $nav_text . ' - ' . BRANCH_NAME;
        $metas['description'] = $nav_text;
        $metas['keywords'] = strtolower($metas['description']);
        $metas['robots'] = "index,follow";
        $data['metas'] = $metas;
        
        $data['main_view'] = $this->load->view('visa/questions/visa_types', $data, TRUE);
        $data['main'] = $this->load->view('visa/questions/layout_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function download()
    {
        $this->load->helper('download');
        
        $file_name = $this->uri->segment(3);
        
        $data = file_get_contents('./' . $this->config->item('visa_file_resource_path') . $file_name); // Read the file's contents
        
        $name = $file_name;
        
        force_download($name, $data);
    }
}
?>
