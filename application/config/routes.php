<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved
| routes must come before any wildcard or regular expression routes.
|
*/

//$route['default_controller'] = "home";


$route['scaffolding_trigger'] = "";
$route['home_search_form'] = 'home/get_hotel_search_form';
$route['getcart'] = 'home/getcart';
$route['getmobilelink'] = 'home/getmobilelink';
$route['tour_request'] = 'aboutus/tour_request';

$route['hotel_search_ajax'] = 'tour_booking/ajax_search_hotel/';
$route['hotel_search_ajax/:any'] = 'tour_booking/ajax_search_hotel/$1';

$route['tour_search_ajax'] = 'tour_booking/ajax_search_tour/';
$route['tour_search_ajax/:any'] = 'tour_booking/ajax_search_tour/$1';

$route['(?i)tours'] = 'vietnam_tours';


//$route['(?i)hotels'] = 'hotels/index';
$route['(?i)deals'] = 'deals/index';
$route['(?i)partners'] = 'partners/index';
$route['(?i)aboutus'] = 'aboutus/index';


$route['tour-detail/show_tab/:any'] = "tour_detail/show_tab/$1";
$route['tour-detail/:any'] = "tour_detail/index/$1";

$route['tour_search/destination=:any'] = "tour_search/index/$1";

//$route['tour-booking/:any'] = "tour_booking/index/$1";

//$route['hotel-booking/:any'] = "hotel_booking/index/$1";



$route['tours-comparison/sort'] = "tours_comparison/sort";
$route['tours-comparison/:any'] = "tours_comparison/index/$1";
$route['links/:any'] = "links/index/$1";
/*
$route['(?i)luxuryhalongcruises'] = "tours/luxuryhalongcruises";


$route['(?i)deluxehalongcruises'] = "tours/deluxehalongcruises";


$route['(?i)cheaphalongcruises'] = "tours/cheaphalongcruises";


$route['(?i)privatehalongcruises'] = "tours/charterhalongcruises";


$route['(?i)halongbaycruises'] = "tours/halongbaycruises";


$route['(?i)halongbaydaycruises'] = "tours/halongbaydaycruises";


$route['(?i)mekongrivercruises'] = "tours/mekongrivercruises";

$route['(?i)luxurymekongcruises'] = "tours/luxurymekongcruises";


$route['(?i)deluxemekongcruises'] = "tours/deluxemekongcruises";


$route['(?i)cheapmekongcruises'] = "tours/cheapmekongcruises";


$route['(?i)privatemekongcruises'] = "tours/chartermekongcruises";

$route['(?i)mekongriverdaycruises'] = "tours/mekongriverdaycruises";

$route['(?i)mekongcruisesvietnamcambodia'] = "tours/vietnamcambodiacruises";

$route['(?i)mekongcruisesvietnam'] = "tours/vietnammekongcruises";

$route['(?i)mekongcruiseslaos'] = "tours/laosmekongcruises";

$route['(?i)mekongcruisesthailand'] = "tours/thailandmekongcruises";

$route['(?i)mekongcruisesburma'] = "tours/burmamekongcruises";
*/

/**
 * Commmended by Khuyenpv on Feb 26 2015
 * New Tour Version has new route at the bottom
 */

//$route['(?i)^Tours_([^\/]*)$'] = TOUR_DESTINATION . '$1'; //English
//$route['(?i)^Tours_([^\/]*)/:any'] = TOUR_DESTINATION .'$1'; //English

//$route['(?i)^Tour_([^\/]*).html$'] = 'tour_detail/index/$1'; //English

//$route['(?i)^Tour_([^\/]*)/([^\/]*).html$'] = 'tour_detail/index/$1';


/*
 * Route for the hotel modules
 */
$route['hotels/search'] = HOTEL_SEARCH;

$route['hotels/search/:any'] = HOTEL_SEARCH. '$1';

$route['hotels/search_empty'] = HOTEL_SEARCH_EMPTY;

$route['hotels/search_empty/:any'] = HOTEL_SEARCH_EMPTY. '$1';

$route['hotels/compare'] = HOTEL_COMPARE;

$route['hotels/compare/:any'] = HOTEL_COMPARE. '$1';

$route['(?i)^Hotels_([^\/]*)$'] = HOTEL_DESTINATION . '$1';


$route['(?i)^Hotel_([^\/]*).html$'] = 'hotel_detail/index/$1';

//$route['(?i)^Hotel-Reviews_([^\/]*).html$'] = 'hotel_detail/review/$1';
//
//$route['(?i)^Hotel-Reviews_([^\/]*).html/:any'] = 'hotel_detail/review/$1';

$route['^Hotel-Reservation_([^\/]*).html$'] = 'hotel_detail/reservation/$1';

$route['^Hotel-Reservation_([^\/]*).html/:any'] = 'hotel_detail/reservation/$1';

/**
 * route for cruise module
 */

//$route['(?i)^Cruise_([^\/]*).html$'] = 'cruise_detail/index/$1';

//$route['(?i)^Cruise-Reviews_([^\/]*).html$'] = 'cruise_detail/cruise_review/$1';

//$route['(?i)^Cruise-Reviews_([^\/]*).html/:any'] = 'cruise_detail/cruise_review/$1';

/**
 * Route for Destination Detail
 */
//$route['(?i)^Destination_([^\/]*).html$'] = 'destination/index/$1';


/**
 * route for faq module
 */
//$route['(?i)^Faqs_([^\/]*).html$'] = 'faqs/question/$1';

//$route['(?i)^Faqs-Category_([^\/]*).html$'] = 'faqs/category/$1';

//$route['(?i)faqs'] = 'faqs/index';

//$route['thank-you.html'] = "thank_you";

//$route['thank_you_request'] = "thank_you";

$route['(?i)vietnam-visa'] 						= "vietnam_visa";
$route['(?i)vietnam-visa/apply-visa.html'] 		= "vietnam_visa/apply_visa";
$route['(?i)vietnam-visa/visa-details.html'] 	= "vietnam_visa/vietnam_visa_details";

$route['(?i)vietnam-visa/visa-fees.html'] = "visa_guides";
$route['(?i)vietnam-visa/visa-requirements.html'] = "visa_guides/visa_requirements";
$route['(?i)vietnam-visa/visa-application.html'] = "visa_guides/visa_application";
$route['(?i)vietnam-visa/visa-for-([^\/]*).html$'] = "visa_guides/visa_for_citizens";
$route['(?i)vietnam-visa/visa-on-arrival.html'] = "visa_guides/visa_on_arrival";
$route['(?i)vietnam-visa/how-to-apply.html'] = "visa_guides/how_to_apply";
$route['(?i)vietnam-visa/visa-types.html'] = "visa_guides/vietnam_visa_types";

$route['(?i)vietnam-visa/vietnam-embassies.html'] = "visa_guides/vietnam_embassies";
$route['(?i)vietnam-visa/vietnam-visa-exemption.html'] = "visa_guides/vietnam_visa_exemption";
$route['(?i)vietnam-visa/vietnam-visa-availability-and-fee.html'] = "visa_guides/vietnam_visa_information";

$route['(?i)vietnam-visa/payment.html'] = "vietnam_visa/visa_payment";

/**
 * Route for Vietnam Flight
 *
 */
/*
$route['(?i)flights'] = "flights";

$route['(?i)flight-search'] = "flights/search/";

$route['(?i)flight-search/:any'] = "flights/search/$1";

$route['(?i)get-flight-data'] = "flights/get_flight_data/";

$route['(?i)get-flight-detail'] = "flights/get_flight_detail/";

$route['(?i)'.FLIGHT_DESTINATION.'-([^\/]*).html$'] = 'flights/flight_to_destination/$1';

$route['(?i)flights/flight-details.html'] 	= "flights/flight_detail";

$route['(?i)flights/payment.html'] = "flights/flight_payment";

$route['(?i)flights/ticket-booked.html'] = "flights/ticket_booked";

*/

/**
 * route for payment module
 */

$route['(?i)payment/success.html'] = "payment/success";

$route['(?i)payment/pending.html'] = "payment/pending";

$route['(?i)payment/unsuccess.html'] = "payment/unsuccess";

$route['(?i)payment/invoice.html'] = "payment/invoice";


/**
 * route for my booking
 */
//$route['(?i)my-booking'] = 'my_booking/index/';
//$route['(?i)my-booking/apply_promo_code'] = 'my_booking/apply_promo_code/';
//$route['(?i)submit-booking'] = 'my_booking/submit/';

$route['touraddcart/:any'] = "tour_detail/add_cart/$1";

$route['tourextrabooking/:any'] = "tour_detail/extra_booking/$1";

//$route['addoptionalservice'] = "tour_booking/save_optional_service_selection_status/";

$route['tournext/:any'] = "/tour_booking/next/$1";

$route['hotelnext/:any'] = "/hotel_booking/next/$1";

$route['hotelreservation/:any'] = "hotel_detail/reservation/$1";

$route['hotelextrabooking/:any'] = "hotel_detail/extra_booking/$1";

//$route['book-together/:any'] = "book/index/$1";

//$route['booktogether/:any'] = "book/addcart/$1";

/**
 * route for promotion ads
 */
$route['ads/([^\/]*).html$'] = "ads/advertising";

$route['book_together.html'] = "ads/advertising/booking_together/";


$route['404_override'] = 'custom_404/index/';

//$route['customize-tours'] = 'aboutus/customize/';
//$route['customize-tours/:any'] = 'aboutus/customize/$1';

//$route['our-team'] = 'aboutus/our_team/';
//
//$route['policy/privacy'] = 'aboutus/privacy/';

//$route['policy'] = 'aboutus/policy/';


/*
| -------------------------------------------------------------------------
| NEW ROUTING FOR BESTPRICE 2015
| -------------------------------------------------------------------------
*/
$route['default_controller'] = "homepage/home";

/**
 * Tour Functions
 */
$route['(?i)tours'] = 'tour/tours';

// top tours of a country
$route['(?i)Top_([^\/]*)-Tours'] = 'tour/tours/top_country_tours/$1';

// tours by travel styles
$route['(?i)Tours_([^\/]*)_([^\/]*)-Tours'] = 'tour/tours/tours_by_travel_style/$1/$2';
$route['(?i)Tours_([^\/]*)_([^\/]*)$'] = 'tour/tours/tours_by_travel_style/$1/$2';

// Tours by destination
$route['(?i)Tours_([^\/]*)-Tours'] = 'tour/tours/tours_by_destination/$1';

// Tour detail page
$route['(?i)Tour_([^\/]*).html'] = 'tour/tour_detail/index/$1'; //English

// Tour booking page
$route['(?i)tour-booking/([^\/]*).html'] = 'tour/tour_booking/index/$1'; //English

// Temporary select optional service in Tour-Booking Page
$route['addoptionalservice'] = "tour/tour_booking/save_optional_service_selection_status/";


// Tour Book-IT route
$route['(?i)tour-book-it/([^\/]*).html'] = 'tour/tour_booking/book_it/$1'; //English

// Tour Add-to-cart route
$route['(?i)tour-add-cart/([^\/]*)/([^\/]*)'] = 'tour/tour_booking/add_cart/$1/$2'; //English


// Tour Destination Autocomplete (Prefetch Mode)
$route['(?i)tour-des-auto-prefetch/tour-des-auto.json'] = 'ajax/tour_ajax/tour_des_auto_prefetch';

// Tour Destination Autocomplete (Remote Mode)
$route['(?i)tour-des-auto-remote/([^\/]*).json'] = 'ajax/tour_ajax/tour_des_auto_remote/$1';

// Tour Recommend More
$route['(?i)recommend-more-tour'] = 'ajax/tour_ajax/recommend_more_tour';
$route['(?i)recommend-more-tour/:num'] = 'ajax/tour_ajax/recommend_more_tour';

// Tour Extra Booking
$route['(?i)tour-extra-booking/([^\/]*)/([^\/]*)'] = 'ajax/tour_ajax/extra_booking/$1/$2';


// Tour Search Functions
$route['(?i)tour-search.html'] 			= 'tour/tour_search/index';
$route['(?i)tour-ajax-search.html'] 	= 'tour/tour_search/ajax_search';
$route['(?i)tour-search-empty.html']	= 'tour/tour_search/search_empty';

// Tour Review
$route['(?i)Tour_([^\/]*).html/Reviews'] = 'tour/tour_detail/index/$1';

// Review page for ajax
$route['(?i)Review_([^\/]*).html'] = 'review/review/index/$1';

// Cruise Price From
$route['cruise-price-from'] = 'ajax/cruise_ajax/get_cruise_price_from';

// Tour Price From
$route['tour-price-from'] = 'ajax/tour_ajax/get_tour_price_from';

// Show More Cruises
$route['show-more-cruise-by-type'] = 'ajax/cruise_ajax/show_more_cruise_by_type';

// Show More Tours
$route['show-more-tours'] = 'ajax/tour_ajax/show_more_tours';

// Get Route Map
$route['get_route_map'] = 'ajax/tour_ajax/get_route_map';

/**
 * Flight Functions
 */
//$route['(?i)flights'] = 'flight/flights';


/**
 * Hotels Functions
 */
$route['(?i)hotels'] = 'hotel/hotels/index';

// Hotel Destination Autocomplete (Prefetch Mode)
$route['(?i)hotel-des-auto-prefetch/hotel-des-auto.json'] = 'ajax/hotel_ajax/hotel_des_auto_prefetch';

// Hotel Destination Autocomplete (Remote Mode)
$route['(?i)hotel-des-auto-remote/([^\/]*).json'] = 'ajax/hotel_ajax/hotel_des_auto_remote/$1';

// Hotel Recommend More
$route['(?i)recommend-more-hotel'] = 'ajax/hotel_ajax/recommend_more_hotel';
$route['(?i)recommend-more-hotel/:num'] = 'ajax/hotel_ajax/recommend_more_hotel';

// Hotel Extra Booking
$route['(?i)hotel-extra-booking/([^\/]*)/([^\/]*)'] = 'ajax/hotel_ajax/extra_booking/$1/$2';
// Hotel Book-IT route
$route['(?i)hotel-book-it/([^\/]*).html'] = 'hotel/hotel_booking/book_it/$1'; //English

$route['(?i)hotel-booking/([^\/]*).html'] = 'hotel/hotel_booking/index/$1';

$route['(?i)hotel-add-cart/([^\/]*)/([^\/]*)'] = 'hotel/hotel_booking/add_cart/$1/$2'; //English

// Hotel Price From
$route['hotel-price-from'] = 'ajax/hotel_ajax/get_hotel_price_from';

// Hotel Search Functions
$route['(?i)hotel-search.html'] 			= 'hotel/hotel_search/index';
$route['(?i)hotel-ajax-search.html'] 	    = 'hotel/hotel_search/ajax_search';
$route['(?i)hotel-search-empty.html']	    = 'hotel/hotel_search/search_empty';

// Hotel details
$route['(?i)^Hotel_([^\/]*).html$']         = 'hotel/hotel_detail/index/$1';
$route['(?i)^Hotel-Reviews_([^\/]*).html']  = 'hotel/hotel_detail/review/$1';

/**
 * MY BOOKING FUNCTIONS
 */
$route['(?i)my-booking'] = 'booking/booking/index/';
//$route['(?i)my-booking/apply_promo_code'] = 'my_booking/apply_promo_code/';
$route['(?i)submit-booking'] = 'booking/booking/submit/';

/**
 * BOOK-TOGETHER PAGES
 */
$route['book-together/([^\/]*)/([^\/]*)/(:num)'] = "booktogether/book_together/index/$1/$2/$3";


/**
 * THANK YOU PAGES
 */
$route['thank-you.html'] = "contact/contact/thank_you";

$route['thank-you-request.html'] = "contact/contact/thank_you";

/**
 * CUSTOMIZE TRIPS
 */
$route['customize-tours'] = 'contact/contact/customize/';
$route['customize-tours/([^\/]*)'] = 'contact/contact/customize/$1';



/**
 * Cruise Functions
 */
$route['(?i)halongbaycruises'] = "cruise/cruises/halongbaycruises";

$route['(?i)luxuryhalongcruises'] = "cruise/cruises/luxuryhalongcruises";

$route['(?i)deluxehalongcruises'] = "cruise/cruises/deluxehalongcruises";

$route['(?i)cheaphalongcruises'] = "cruise/cruises/cheaphalongcruises";

$route['(?i)privatehalongcruises'] = "cruise/cruises/charterhalongcruises";

$route['(?i)halongbaydaycruises'] = "cruise/cruises/halongbaydaycruises";

$route['(?i)halongfamilycruises'] = "cruise/cruises/halongfamilycruises";

$route['(?i)halonghoneymooncruises'] = "cruise/cruises/halonghoneymooncruises";

$route['(?i)halongbigsizecruises'] = "cruise/cruises/halongbigsizecruises";

$route['(?i)halongmediumsizecruises'] = "cruise/cruises/halongmediumsizecruises";

$route['(?i)halongsmallsizecruises'] = "cruise/cruises/halongsmallsizecruises";


$route['(?i)mekongrivercruises'] = "cruise/cruises/mekongrivercruises";

$route['(?i)mekongcruisesvietnamcambodia'] = "cruise/cruises/vietnamcambodiacruises";

$route['(?i)mekongcruisesvietnam'] = "cruise/cruises/vietnamcruises";

$route['(?i)mekongcruiseslaos'] = "cruise/cruises/laoscruises";

$route['(?i)mekongcruisesthailand'] = "cruise/cruises/thailandcruises";

$route['(?i)mekongcruisesburma'] = "cruise/cruises/burmacruises";

$route['(?i)luxurymekongcruises'] = "cruise/cruises/luxurymekongcruises";

$route['(?i)deluxemekongcruises'] = "cruise/cruises/deluxemekongcruises";

$route['(?i)cheapmekongcruises'] = "cruise/cruises/cheapmekongcruises";

$route['(?i)privatemekongcruises'] = "cruise/cruises/privatemekongcruises";

$route['(?i)mekongriverdaycruises'] = "cruise/cruises/mekongriverdaycruises";


$route['(?i)^Cruise_([^\/]*).html'] = 'cruise/cruise_detail/index/$1';
$route['(?i)^Cruise-Reviews_([^\/]*).html'] = 'cruise/cruise_detail/review/$1';

$route['(?i)cruise_detail/get_videos'] = 'cruise/cruise_detail/get_videos';
$route['(?i)cruise_detail/get_itinerary'] = 'cruise/cruise_detail/get_itinerary';
$route['(?i)cruise_detail/get_cruise_properties_deckplans'] = 'cruise/cruise_detail/get_cruise_properties_deckplans';


/**
 * FAQ pages
 */
$route['(?i)faqs'] = 'faq/faqs';
$route['(?i)^Faqs_([^\/]*).html$'] = 'faq/faqs/faq_detail/$1';
$route['(?i)^Faqs-Category_([^\/]*).html$'] = 'faq/faqs/index/$1';
$route['(?i)^Faqs-Destination_([^\/]*).html$'] = 'faq/faqs/destination/$1';

/**
 * Destination pages
 */
$route['(?i)^Destination_([^\/]*).html'] = 'guide/destinations/index/$1';
$route['(?i)^Things-to-do_([^\/]*)_([^\/]*).html'] = 'guide/destinations/thing_todo_detail/$1/$2';
$route['(?i)^Thing-to-do_([^\/]*).html'] = 'guide/destinations/things_to_do/$1';
$route['(?i)^Attraction_([^\/]*).html'] = 'guide/destinations/attraction/$1';
$route['(?i)^City-in_([^\/]*).html'] = 'guide/destinations/attraction/$1';

$route['(?i)^Article_([^\/]*)_([^\/]*).html'] = 'guide/destinations/article_detail/$1/$2';
$route['(?i)^Article_([^\/]*).html'] = 'guide/destinations/travel_article/$1';

$route['(?i)^Article_([^\/]*).html/(:any)'] = 'guide/destinations/travel_article/$1';

$route['(?i)^Information_([^\/]*)_([^\/]*).html'] = 'guide/destinations/useful_information/$1/$2';

/**
 * Deal Functions
 */
$route['(?i)deals'] = 'deal/deals';

/**
 * Visa Functions
 */
$route['(?i)vietnam-visa']                          = 'visa/visas';
$route['(?i)vietnam-visa/apply-visa.html']          = "visa/visas/apply_visa";
$route['(?i)vietnam-visa/visa-details.html'] 	    = "visa/visas/visa_details";
$route['(?i)vietnam-visa/payment.html']             = "visa/visa_payment";

$route['(?i)vietnam-visa/visa-for-([^\/]*).html$']  = "visa/visa_guides/visa_for_citizens";
$route['(?i)vietnam-visa/visa-fees.html']           = "visa/visa_guides";
$route['(?i)vietnam-visa/visa-requirements.html']   = "visa/visa_guides/visa_requirements";
$route['(?i)vietnam-visa/visa-application.html']    = "visa/visa_guides/visa_application";
$route['(?i)vietnam-visa/visa-on-arrival.html']     = "visa/visa_guides/visa_on_arrival";
$route['(?i)vietnam-visa/how-to-apply.html']        = "visa/visa_guides/how_to_apply";
$route['(?i)vietnam-visa/visa-types.html']          = "visa/visa_guides/visa_types";
$route['(?i)vietnam-visa/vietnam-embassies.html']    = "visa/visa_guides/visa_embassies";
$route['(?i)vietnam-visa/vietnam-visa-availability-and-fee.html']    = "visa/visa_guides/visa_availability";
$route['(?i)vietnam-visa/vietnam-visa-exemption.html']    = "visa/visa_guides/visa_exemption";


/**
 * About Us page
 */
$route['(?i)aboutus'] = 'about/about_us/index';

$route['(?i)aboutus/registration'] = 'about/about_us/registration';

$route['(?i)policy'] = 'about/about_us/policy';

$route['(?i)policy/privacy'] = 'about/about_us/privacy';

$route['(?i)our-team'] = 'about/about_us/our_team';

$route['(?i)aboutus/contact'] = 'about/about_us/contact_us';

$route['(?i)aboutus/contact/([^\/]*)'] = 'about/about_us/contact_us/$1';

$route['(?i)aboutus/contact/claim/([^\/]*)'] = 'about/about_us/contact_us/$1';

$route['(?i)aboutus/contact/claim/([^\/]*)/([^\/]*)'] = 'about/about_us/contact_us/$1/$2';

/**
 * Route for Vietnam Flight New
 *
 */

$route['(?i)flights'] = "flight/flights";

$route['(?i)'.FLIGHT_DESTINATION.'-([^\/]*).html$'] = 'flight/flights/flight_to_destination/$1';

$route['(?i)'.FLIGHT_SEARCH_PAGE.''] = "flight/flight_search";

$route['(?i)'.FLIGHT_SEARCH_EXCEPTION_PAGE.'?:any$'] = "flight/flight_search/exception";

$route['(?i)get-flight-data'] = "flight/flight_search/get_flight_data/";

$route['(?i)get-flight-detail'] = "flight/flight_search/get_flight_detail/";

$route['(?i)get-flight-detail-inter'] = "flight/flight_search/get_flight_detail_inter/";

$route['(?i)'.FLIGHT_PASSENGER_PAGE] 	= "flight/flight_booking";

$route['(?i)'.FLIGHT_PAYMENT_PAGE] = "flight/flight_payment";

/**
 * Route get cart
 *
 */

$route['getcart'] = 'homepage/home/getcart';

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */