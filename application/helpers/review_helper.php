<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get customer review for tour details and cruise details
 *
 * @author toanlk
 * @since  Mar 19, 2015
 */
function load_review_overview($data, $is_mobile, $review_score, $nr_reviews, $review_link, $rich_snippet = null)
{
    $CI = & get_instance();
    $mobile_folder = $is_mobile ? 'mobile/' : '';

    $review_overview = '';

    if (! empty($review_score))
    {
        $review_data['review_link'] = $review_link;

        $review_data['review_score'] = $review_score;

        $review_data['number_of_reviews'] = $nr_reviews;

        $review_data['rich_snippet'] = $rich_snippet;

        $review_overview = $CI->load->view($mobile_folder . 'reviews/review_overview', $review_data, TRUE);
    }

    $data['review_overview'] = $review_overview;

    return $data;
}

/**
 * Load customer reviews
 *
 * @author toanlk
 * @since  Apr 1, 2015
 */
function load_customer_reviews($data, $is_mobile, $review_object, $service_type, $is_ajax = false, $is_paging = false){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	// Load language
	$CI->load->language(array('review', 'tourdetail'));
	$CI->load->library('pagination');
	$CI->load->model(array('Review_Model', 'Cruise_Model'));

	// get post data
	$view_data = _build_review_search_param($review_object, $service_type);

	$view_data['object'] = $review_object;

	$search_criteria = $view_data['search_criteria'];

	$offset = ! empty($view_data['search_criteria']['page']) ? $search_criteria['page'] : 0;

    if(!empty($search_criteria['cruise_id'])) {
        $tours = $CI->Cruise_Model->get_cruise_tours($search_criteria['cruise_id']);

        $tour_ids = array();
        foreach ($tours as $tour) {
            $tour_ids[] = $tour['id'];
        }
        $search_criteria['tour_ids'] = $tour_ids;
    }

	// get reviews from db
	$view_data['reviews'] = $CI->Review_Model->get_reviews($search_criteria, $offset);

	$view_data['count_results'] = $CI->Review_Model->get_num_reviews($search_criteria);

	// Score Types: location, services, ...etc
	$score_type_config = $CI->config->item('score_types');

	if(!empty($review_object['cruise_id'])) {
	    $score_types = $score_type_config[CRUISE];
	} else {
	    $score_types = $score_type_config[$service_type];
	}

	$scores = $CI->Review_Model->get_review_scores($search_criteria);

	$view_data['customer_countries'] = $CI->config->item('countries');

	$view_data['score_types'] = _getAverageScores($score_types, $scores);

	// Score Breakdown: excellent, good, ...etc
	$view_data['score_breakdown'] = _getNumberReviewsEachType($search_criteria, 'review_rate_types');

	// Customer Types: family, couple, ...etc
	$view_data['customer_types'] = _getNumberReviewsEachType($search_criteria, 'customer_types');

	// Prevent round inaccurate total score
	$view_data['total_score'] = _getTotalScore($view_data['score_types']);

	if ($is_mobile){
		$view_data['paging_config_mobile'] = $CI->config->item('paging_config_mobile');
	}
	
	// set paging
	$view_data = _set_review_paging($view_data, $search_criteria, $offset);

	$view_data['review_list'] = $CI->load->view($mobile_folder . 'reviews/review_list', $view_data, TRUE);

	$data['customer_reviews'] = $CI->load->view($mobile_folder . 'reviews/review_list_score', $view_data, TRUE);

	// Load view
	if ($is_ajax)
    {
        if($is_paging) {
            return $view_data['review_list'];
        } else {
            return $data['customer_reviews'];
        }
    }

    return $data;
}

function _set_review_paging($data, $search_criteria, $offset)
{
    $CI =& get_instance();

    $uri = get_review_url($search_criteria, $data['object']);

    $paging_config_mobile = !empty($data['paging_config_mobile']) ? $data['paging_config_mobile'] : null;
    
	$paging_config = create_paging_config($data['count_results'], $uri, 1, $paging_config_mobile, true);
	
	// initialize pagination
	$CI->pagination->initialize($paging_config);

	$paging_info['paging_links'] = $CI->pagination->create_links();
	
	$paging_info['paging_text'] = create_paging_text($data['count_results'], $offset, $paging_config_mobile);

	$data['paging_info'] = $paging_info;

    return $data;
}


/**
  * get_review_link
  *
  * @author toanlk
  * @since  Jun 15, 2015
  */
function get_review_link($object, $module)
{
    if (empty($object['review_number']))
    {
        return lang('review_zero');
    }
    else
    {
        $rel = '';

        if ($module == CRUISE)
        {
            $href = get_page_url(CRUISE_REVIEW_PAGE, $object);
        }
        elseif ($module == HOTEL)
        {
            $href = get_page_url(HOTEL_REVIEW_PAGE, $object);
        }
        elseif ($module == TOUR)
        {
            $href = get_page_url(TOUR_REVIEW_PAGE, $object);

            $rel = ' rel="nofollow" ';
        }

        $link = '<a style="text-decoration: underline"'. $rel .' href="' . $href . '">' . $object['review_number'] . ' ';

        if ($object['review_number'] == 1)
        {
            $link = $link . lang('review');
        }
        else
        {
            $link = $link . lang('reviews');
        }
        return $link . '</a>';
    }
}

function _build_review_search_param($review_object, $service_type)
{
    $CI =& get_instance();

    $data = array();
    $search_criteria = array();

    // get platform
    /* $mobile = $CI->input->get('on_mobile');

    if (! empty($mobile) && $mobile == 1 )
    {
    $search_criteria['mobile'] = $mobile;
    } */

    if ($service_type == TOUR || ( $service_type == CRUISE && !empty($review_object['cruise_id']) ) )
    {
        $search_criteria['tour_id'] = $review_object['id'];
    }
    elseif ($service_type == HOTEL)
    {
        $search_criteria['hotel_id'] = $review_object['id'];
    }
    elseif ($service_type == CRUISE)
    {
        $search_criteria['cruise_id'] = $review_object['id'];
    }

    $review_score = $CI->input->get('review_score');

    if ($review_score != '')
    {
        $search_criteria['review_score'] = $review_score;
    }

    $customer_type = $CI->input->get('customer_type');

    if ($customer_type != '')
    {
        $search_criteria['customer_type'] = $customer_type;
    }

    $page = $CI->input->get('page');

    if ($page != '')
    {
        $search_criteria['page'] = $page;
    }

    if(!empty($review_object['cruise_id'])) {
        $service_type= CRUISE;
    }

    $search_criteria['review_for_type'] = $service_type;

    $data['search_criteria'] = $search_criteria;

    return $data;
}

/**
 *  get_full_review_text
 *
 *  @author toanlk replated by TinVM May25 2015
 *  @since  Oct 27, 2014
 */
function get_text_review($object, $module = TOUR, $is_show_link = true, $is_text_front = false, $is_icon_bg = false)
{
    $text_review = '';

    if (! empty($object['review_number']))
    {
        $r_text = $object['review_number'] == 1 ? lang('review') : lang('reviews');

        $icon_bg = $is_icon_bg ? 'icon icon-review-bg ' : '';

        $text_review = '<label class="'.$icon_bg.'text-highlight"><b class="review-score">' . $object['total_score'] . '</b></label> ' . lang('common_paging_of') . ' ';

        if ($is_show_link)
        {
            $text_review = $text_review . ' <i>' . get_review_link($object, $module) . '</i>';
        }
        else
        {
            $text_review = $text_review . $object['review_number'] . ' ' . $r_text;
        }

        $score_lang = '<span class="review-text">' . get_review_score_lang($object['total_score']) . '</span>';

        if($is_text_front) {
            $text_review = $score_lang . ' - ' . $text_review;
        } else {
            $text_review = $text_review . ' - ' . $score_lang;
        }

    }

    return $text_review;
}

/**
 * get_review_score_lang
 *
 * @author toanlk
 * @since  Mar 19, 2015
 */
function get_review_score_lang($score)
{
    $score_lang = '';

    if ($score >= 9)
    {
        $score_lang = '<label class="text-choice">' . lang('review_rate_excellent') . '</label>';
    }
    else if ($score >= 8 && $score < 9)
    {
        $score_lang = '<label class="text-highlight">' . lang('review_rate_very_good') . '</label>';
    }
    else if ($score >= 7 && $score < 8)
    {
        $score_lang = '<label class="text-highlight">' . lang('review_rate_good') . '</label>';
    }
    else if ($score >= 6 && $score < 7)
    {
        $score_lang = lang('review_rate_average');
    }
    else if ($score >= 5 && $score < 6)
    {
        $score_lang = lang('review_rate_poor');
    }
    else if ($score < 5)
    {
        $score_lang = lang('review_rate_terrible');
    }

    return $score_lang;
}

function get_review_url($search_criteria, $obj, $filter_name = null, $filter_value = null, $is_remove = false) {

    $param = '';

    if(!empty($filter_name)) {

        if($filter_name == 'review_customer_types') {
            $search_criteria['customer_type'] = $filter_value;
        }

        if($filter_name == 'review_score_breakdown') {
            $search_criteria['review_score'] = $filter_value;
        }

        // remove parameters
        if($is_remove) {
            unset($search_criteria[$filter_name]);
        }
    }

    foreach ($search_criteria as $key => $value) {

        if(is_array($value)) continue;

        if($key == 'page') continue;

        if(empty($param)) {
            $param = '?'.$key.'='.$value;
        } else {
            $param .= '&'.$key.'='.$value;
        }

    }

    $current_url = str_replace('%s', $obj['url_title'], REVIEW_PAGE);

    $url = $current_url . $param;

    return $url;
}

function get_review_paging_config($total_rows, $uri, $uri_segment) {
    $CI =& get_instance();

    $config['base_url'] = site_url($uri);
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $CI->config->item('per_page');
    $config['uri_segment'] = $uri_segment;
    $config['num_links'] = $CI->config->item('num_links');
    $config['first_link'] = $CI->lang->line('common_paging_first');
    $config['next_link'] = $CI->lang->line('common_paging_next');
    $config['prev_link'] = $CI->lang->line('common_paging_previous');
    $config['last_link'] = $CI->lang->line('common_paging_last');

    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';

    return $config;
}

function _getNumberReviewsEachType($search_criteria, $filter_name)
{
    $CI =& get_instance();

    $ret = array();
    $filter_types = $CI->config->item($filter_name);

    foreach ($filter_types as $key => $value) {

        if($filter_name == 'customer_types') {
            $search_criteria['customer_type'] = $key;
        }

        if($filter_name == 'review_rate_types') {
            $search_criteria['review_score'] = $key;
        }

        $ret[] = array(
            'key' => $key,
            'name' => $value,
            'value' => $CI->Review_Model->get_num_reviews($search_criteria),
        );
    }

    return $ret;
}

function _getAverageScoreByType($type, $scores){
    $index = 0;
    $score = 0;
    foreach ($scores as $value) {

        if ($type == $value['score_type']){

            $score = $score + $value['score'];

            $index = $index + 1;
        }

    }
    if ($index != 0){
        return round($score/$index,1);
    }
}

function _getAverageScores($score_types, $scores){

    $ret = array();

    foreach ($score_types as $key=>$value) {
        $ret[] = array(
            'key' => $key,
            'name' => $value,
            'value' => _getAverageScoreByType($key, $scores),
        );
    }

    return $ret;
}

function _getTotalScore($average_scores) {

    $total = 0;

    if ( !empty($average_scores) )
    {
        foreach ($average_scores as $value) {
            $total = $total + $value['value'];
        }

        $total = round($total/count($average_scores), 1);
    }

    return $total;
}

function is_filter_selected($search_criteria, $filter_name, $filter_value) {

    foreach ($search_criteria as $key => $value) {
        if($key == $filter_name
            && $filter_value == $value) {
                return true;
            }
    }

    return false;
}

function get_filter_selections($search_criteria, $obj, $score_breakdown, $customer_types) {

    $txt = '';

    foreach ($search_criteria as $key => $value) {
        if($key == 'review_score') {
            foreach ($score_breakdown as $score) {
                if($score['key'] == $value) {
                    $url = get_review_url($search_criteria, $obj, 'review_score', $value, true);

                    $btn = '<a class="btn-filter review_filter" data-url="'.$url.'" href="javascript:void(0)">';
                    $btn .= translate_text($score['name']).'<span class="icon icon-review-remove"></span></a>';

                    $txt .= $btn;
                }
            }
        }

        if($key == 'customer_type') {
            foreach ($customer_types as $cus) {
                if($cus['key'] == $value) {
                    $url = get_review_url($search_criteria, $obj, 'customer_type', $value, true);

                    $btn = '<a class="btn-filter review_filter" data-url="'.$url.'" href="javascript:void(0)">';
                    $btn.= translate_text($cus['name']).'<span class="icon icon-review-remove"></span></a>';

                    $txt .= $btn;
                }
            }
        }
    }

    return $txt;
}
?>