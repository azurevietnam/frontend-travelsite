<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| Define Date format
|--------------------------------------------------------------------------
*/
define('DATE_FORMAT',				'F d, Y'); // not support dd/mm/yyyy
define('DATE_FORMAT_JS',			'dd-mm-yy'); // use in js calendar - must the same DATE_FORMAT
define('DATE_FORMAT_LBL',			'(dd-mm-yyyy)');
define('DATE_TIME_FORMAT',			'F d, Y H:i:s');
// don't change this value for db date format
define('DB_DATE_FORMAT',			'Y-m-d');
define('DB_DATE_TIME_FORMAT',		'Y-m-d H:i:s');
define('DATE_FORMAT_STANDARD',		'd-m-Y'); // not support dd/mm/yyyy
define('DATE_FORMAT_SHORT',			'd M y'); // not suppmort dd/mm/yyyy
define('DATE_FORMAT_DISPLAY',		'd M Y'); // not suppmort dd/mm/yyyy

define('FLIGHT_DATE_FORMAT',		'D, d M Y');
define('DATE_FORMAT_CART_TIMESTAMP','Y_m_d_H_i_s');

define('DATE_FORMAT_DISPLAY_I18N',	'%d %b %Y');
define('DATE_FORMAT_STANDARD_I18N',	'%d-%m-%Y'); // not support dd/mm/yyyy

define('ARTICLES_DATE_FORMAT',		'd/m/Y | H:i');

/*
|--------------------------------------------------------------------------
| Define System parameter
|--------------------------------------------------------------------------
*/
define('SITE_NAME',	'Bestpricevn.com');
define('BRANCH_NAME',	'Best Price Vietnam');
define('DES_SYSTEM',	1);
define('DES_USER',	2);
define('STATUS_ACTIVE',	1);
define('STATUS_INACTIVE',	0);
define('DELETED', 1);
define('D_BOOKING_TIME', 60);
define('LIMIT_BEST_SELLER_CATS', 3);
define('LIMIT_BEST_SELLERS', 5);
define('LIMIT_BEST_DEALS', 3);
define('LIMIT_TOUR_PER_PAGE', 2);
define('CURRENCY_SYMBOL', '$');
define('CURRENCY_DECIMAL', 0);
define('ADULT_LIMIT', 10);
define('CHILDREN_LIMIT', 5);
define('CABIN_LIMIT', 6);
define('SIMILAR_TOUR_LIMIT', 5);
define('PRIVATE_TOUR', 4);
define('GROUP_TOUR', 5);

define('HOTEL_NIGHT_LIMIT', 15);

define('DAY_TOUR', 9);
define('LIMIT_TOUR_ON_TAB', 6);
define('LIMIT_HOTEL_ON_TAB', 6);
define('LIMIT_MORE_TOUR', 10);

define('SINGLE_SUP_LIMIT', 5);
define('SPECIAL_OFFER_RATE', 10);
define('TOUR_DESCRIPTION_CHR_LIMIT', 140);
define('TOUR_VN_DESCRIPTION_CHR_LIMIT', 140);
define('PARTNER_CHR_LIMIT', 21);
define('TOUR_NAME_CHR_LIMIT', 21);
define('TOUR_NAME_LIST_CHR_LIMIT', 40);
define('ARROW_LINK', '<span class="arrow">&rsaquo;</span>');
define('CUSTOMER_REVIEW_LIMIT', 300);

define('HOTEL_DESCRIPTION_CHR_LIMIT', 130);//200);

define('SHORT_HOTEL_DESCRIPTION_CHR_LIMIT', 350);

define('CRUISE_DESCRIPTION_CHR_LIMIT', 150);

define('SUBSCRIBE_EMAIL', 'sales@bestpricevn.com');

define('TOUR_NAME_HOT_DEAL_LIMIT', 27);

define('DEPARTURE_MONTH_SHOW_LIMIT', 4);

define('VISA_URGENT_SERVICE', 2);

/*
|--------------------------------------------------------------------------
| Define Tours Action
|--------------------------------------------------------------------------
*/
define('VIETNAM_PACKAGE_TOURS', 'vietnampackagetours/');
define('VIETNAM_BEACH_VACATION', 'vietnambeachvacation/');
define('VIETNAM_ADVENTURE_TOURS', 'vietnamadventuretours/');
define('VIETNAM_CULTURE_TOURS', 'vietnamculturetours/');

define('HALONG_BAY_CRUISES', 'halongbaycruises/');
define('LUXURY_HALONG_CRUISES', 'luxuryhalongcruises/');
define('DELUXE_HALONG_CRUISES', 'deluxehalongcruises/');
define('CHEAP_HALONG_CRUISES', 'cheaphalongcruises/');
define('CHARTER_HALONG_CRUISES', 'privatehalongcruises/');
define('HALONG_BAY_DAY_CRUISES', 'halongbaydaycruises/');

define('MEKONG_RIVER_CRUISES', 'mekongrivercruises/');
define('LUXURY_MEKONG_CRUISES', 'luxurymekongcruises/');
define('DELUXE_MEKONG_CRUISES', 'deluxemekongcruises/');
define('CHEAP_MEKONG_CRUISES', 'cheapmekongcruises/');
define('CHARTER_MEKONG_CRUISES', 'privatemekongcruises/');
define('MEKONG_RIVER_DAY_CRUISES', 'mekongriverdaycruises/');
define('VIETNAM_CAMBODIA_CRUISES', 'mekongcruisesvietnamcambodia/');
define('VIETNAM_CRUISES', 'mekongcruisesvietnam/');
define('LAOS_CRUISES', 'mekongcruiseslaos/');
define('THAILAND_CRUISES', 'mekongcruisesthailand/');
define('BURMA_CRUISES', 'mekongcruisesburma/');
define('CAMBODIA_CRUISES', 'mekongcruisescambodia/');

define('DEALS', 'deals/');

define('TOUR_HOME', 'tours/');
//define('TOUR_SEARCH', TOUR_HOME . 'search/');
//define('TOUR_SEARCH_EMPTY', TOUR_HOME . 'search_empty/');
define('TOUR_DESTINATION', 'vietnam_tours/tours_by_destinations/');
define('TOUR_DESTINATION_STYLES','tour_destination_styles');
define('TOUR_TRAVEL_STYLE', TOUR_HOME . 'travel-styles/');
define('TOUR_DETAIL', 'Tour');
define('TOUR_BOOKING', 'tour-booking/');
define('TOURS_COMPARISON', 'tours-comparison/');
define('LINK_EXCHANGE', 'links/');

define('MY_BOOKING', 'my-booking/');

define('SUBMIT_BOOKING', 'submit-booking/');

define('BOOK_TOGHETHER', 'book/');

define('TOUR_SEARCH', '/tour_search/');
define('TOUR_SEARCH_EMPTY', TOUR_SEARCH.'search_empty/');

define('HOTEL_HOME', 'hotels/');
define('HOTEL_SEARCH', 'hotel_list/search/');
define('HOTEL_COMPARE', 'hotel_list/compare/');
define('HOTEL_SEARCH_EMPTY', 'hotel_list/search_empty/');
//define('HOTEL_DESTINATION','hotel_list/index/');
define('HOTEL_DETAIL', 'Hotel');
define('HOTEL_REVIEWS', 'Hotel-Reviews');
define('HOTEL_BOOKING', 'hotel-booking/');

define('CRUISE_HOME', 'cruises/');
define('CRUISE_HALONG_BAY', 'cruises/halongbay/');
define('CRUISE_MEKONG_RIVER', 'cruises/mekongriver/');
define('CRUISE_SEARCH', 'cruises/search/');
define('CRUISE_COMPARE', 'cruises/compare/');
define('CRUISE_SEARCH_EMPTY', 'cruises/search_empty/');
define('CRUISE_DETAIL', 'Cruise');
define('CRUISE_PROGRAM_DETAIL', 'Cruise-Tour');
define('CRUISE_REVIEWS', 'Cruise-Reviews');
define('CRUISE_BOOKING', 'Cruise-Reservation');

define('DESTINATION_DETAIL', 'Destination');

define('PARTNERS', 'partners/');
define('MODULE_TOURS', 'Tours');
define('MODULE_HOTELS', 'Hotels');
define('VIETNAM_VISA', 'vietnam-visa/');
define('APPLY_VIETNAM_VISA', 'vietnam-visa/apply-visa.html');

/*
 * VIETNAM FLIGHT
 */
define('FLIGHT_HOME', 'flights/');
define('FLIGHT_DESTINATION', 'flights/flight-to');
define('FLIGHT_SEARCH', 'flight-search/');
define('FLIGHT_DETAIL','flights/flight-details.html');
define('FLIGHT_PAYMENT','flights/payment.html');

define('FLIGHT_DESTINATION_PAGE', 'flights/flight-to-%s.html');

define('FLIGHT_SEARCH_PAGE', 'flight-search.html');

define('FLIGHT_SEARCH_EXCEPTION_PAGE', 'flight-search-exception.html');

define('FLIGHT_PASSENGER_PAGE', 'flights/flight-details.html');

define('FLIGHT_PAYMENT_PAGE', 'flights/payment.html');

define('FLIGHT_SEARCH_HISTORY', 'FLIGHT_SEARCH_HISTORY');


define('ABOUT_US', 'aboutus/');
define('FAQ', 'faqs/');
define('FAQ_DETAIL', 'Faqs');
define('FAQ_CATEGORY', 'Faqs-Category');
define('PARTNERS_META', 'partners');
define('LOGIN', 'customer_login/');
define('FAQ_TOUR_ID','25');

define('CUSTOM_404', 'custom_404/');

define('OVERVIEW_TAB', 'Overview');
define('ITINERARY_TAB', 'Itinerary');
define('PRICE_TAB', 'Price');
define('GALLERY_TAB', 'Gallery');
define('REVIEWS_TAB', 'Reviews');

/*
 *
 * Define service type
 *
 */
define('TOUR', 0);
define('HOTEL', 1);
define('CRUISE', 2);
define('FLIGHT', 3);
define('CAR', 4);
define('RESTAURANT', 5);
define('VISA', 6);

/*
 * Define cruise destination
 */
define('HALONG_CRUISE_DESTINATION', 0);
define('MEKONG_CRUISE_DESTINATION', 1);

/*
 * Define indochina country id
 */
define('VIETNAM', 235);
define('LAOS', 306);
define('CAMBODIA', 234);
define('HALONG_BAY', 5);
define('INDOCHINA', 408);
define('MEKONG_DELTA', 227);
define('MYANMAR', 420);
define('MEKONG_RIVER', 798);

/*
 * Define destination url-title
 */
define('HALONG_BAY_URL_TITLE', 'Halong-Bay');
define('MEKONG_RIVER_URL_TITLE', 'Mekong-River');

/*
 * Define score type
 */
define('VIETNAM_CAMBODIA_CRUISE_DESTINATION', '1');
define('VIETNAM_CRUISE_DESTINATION', '2');
define('CAMBODIA_CRUISE_DESTINATION', '3');
define('LAOS_CRUISE_DESTINATION', '4');
define('THAILAND_CRUISE_DESTINATION', '5');
define('BURMA_CRUISE_DESTINATION', '6');

/*
 * Define score type
 */
define('TYPE_CLEAN', 0);
define('TYPE_COMFORT', 1);
define('TYPE_LOCATION', 2);
define('TYPE_SERVICES', 3);
define('TYPE_STAFF', 4);
define('TYPE_VALUE_MONEY', 5);
define('TYPE_CRUISE_QUALITY', 6);
define('TYPE_DINING_FOOD', 7);
define('TYPE_CABIN_QUALITY', 8);
define('TYPE_STAFF_QUALITY', 9);
define('TYPE_ENTERTAIMENT_ACTIVITY', 10);
define('TYPE_ITINERARY', 11);

define('VIETNAM_PACKAGE_TOUR_ID', 1);
define('HALONG_CRUISE_ID', 2);
define('MEKONG_CRUISE_ID', 3);
define('VIETNAM_BEACH_VACATION_ID', 4);
define('VIETNAM_ADVENTURE_TOUR_ID', 5);
define('VIETNAM_CULTURE_TOUR_ID', 6);

define('BESTPRICE_VIETNAM_ID', 1);

define('URL_SUFFIX', '.html');
define('URL_SEPARATOR', '_');

/*
|--------------------------------------------------------------------------
| System Menus
|--------------------------------------------------------------------------
*/
define('MNU_HOME',					'MNU_HOME');
define('MNU_VN_TOURS',				'MNU_VN_TOURS');
define('MNU_HALONG_CRUISES',		'MNU_HALONG_CRUISES');
define('MNU_MEKONG_CRUISES',		'MNU_MEKONG_CRUISES');
define('MNU_HOTELS',				'MNU_HOTELS');
define('MNU_PARTNERS',				'MNU_PARTNERS');
define('MNU_ABOUT_US',				'MNU_ABOUT_US');
define('MNU_CONTACT_US',			'MNU_CONTACT_US');
define('MNU_FAQ',					'MNU_FAQ');
define('MNU_CRUISE',				'MNU_CRUISE');
define('MNU_DEAL_OFFER',			'MNU_DEAL_OFFER');
define('MNU_LOGIN',					'MNU_LOGIN');
define('MNU_VN_VISA',				'MNU_VN_VISA');
define('MNU_FLIGHTS',				'MNU_VN_FLIGHT');

/*
 * Define Hotel Facility Types
 */
define('HOTEL_FACILITY_GENERAL', 0);
define('HOTEL_FACILITY_SERVICE', 1);
define('HOTEL_FACILITY_ACTIVITY', 2);

define('CRUISE_FACILITY_GENERAL', 0);
define('CRUISE_FACILITY_SERVICE', 1);
define('CRUISE_FACILITY_ACTIVITY', 2);
define('CRUISE_FACILITY_ACTIVITY_ON_REQUEST', 3);

/**
 * service type
 */
define('SERVICE_TYPE_INCLUDED', 1);
define('SERVICE_TYPE_REQUIRED', 2);
define('SERVICE_TYPE_OPTIONAL', 3);
define('SERVICE_TYPE_TRANSPORTATION', 4);
define('SERVICE_TYPE_CABIN', 5);

/**
 * Review Source
 */
define('TRIP_ADVISOR', 0);
define('LONELY_PLANET', 1);
define('VIRTUAL_TOURIST', 2);
define('EXPEDIA', 3);
define('PRICE_LINE', 4);
define('BOOKING', 5);
define('AGODA', 6);
define('HOTELS', 7);
define('BEST_PRICE', 8);

define('Surcharge_Christmas', 9);
define('Surcharge_New_Year', 8);
define('Surcharge_Lunar_New_Year', 10);
define('Surcharge_Saigon_Independence_Day', 30);

define('Christmas', '24-12');
define('New_Year', '31-12');
define('Saigon_Independence_Day', '30-04');

define('CUSTOMER_LOGIN', 'CUSTOMER_LOGIN');

/**
 * Constant for cabin price typ
 *
 */

define('PRICE_BY_PERSON', 0);
define('PRICE_DOUBLE_EXTRA', 1);
define('PRICE_DOUBLE', 2);
define('PRICE_SINGLE', 3);


/**
 * Constant for file type
 *
 */
define('IS_CSS', 1);
define('IS_JAVASCRIPT', 2);

/**
 * Cart item type
 */
define('ITEM_TYPE_MAIN',1);

define('ITEM_TYPE_CHILD',2);

define('RESERVATION_TYPE_CRUISE_TOUR',1);

define('RESERVATION_TYPE_HOTEL',2);

define('RESERVATION_TYPE_TRANSFER',3);

define('RESERVATION_TYPE_LAND_TOUR',4);

define('RESERVATION_TYPE_OTHER',5);

define('RESERVATION_TYPE_ADDITONAL_CHARGE',6);

define('RESERVATION_TYPE_VISA',7);

define('RESERVATION_TYPE_FLIGHT',8);

define('RESERVATION_TYPE_NONE',-1);

/**
 * Super save discount: > $10
 *
 */
define('SUPER_SAVE', 10);


/**
 *
 * Booking Site
 *
 */

define('SITE_BESTPRICEVN_COM', 1);

define('SITE_HALONGBYJUNKBOAT_COM', 2);

define('SITE_HALONG_BAY_JUNK_BOAT_COM', 2);

define('SITE_HALONG_BAY_BOAT_TRIP_COM', 3);

define('SITE_BEST_HALONG_BAY_CRUISE_COM', 4);

define('SITE_MEKONG_DELTA_CRUISE_NET', 5);

define('SITE_BEST_MEKONG_CRUISE_COM', 6);

define('SITE_BEST_SAPA_TOURS_COM', 7);

define('SITE_INDOCHINA_TOURS_COM', 8);

/**
 * REQUEST TYPE
 */

define('REQUEST_TYPE_RESERVATION', 1);

define('REQUEST_TYPE_REQUEST', 2);


/**
 *
 * CUSTOME TYPE
 *
 */
define('CUSTOMER_TYPE_NEW', 1);

define('CUSTOMER_TYPE_RETURN', 2);

define('CUSTOMER_TYPE_RECOMMENDED', 3);

define('PROMOTION_TYPE_NORMAL', 1);
define('PROMOTION_TYPE_EARLY_BIRD', 2);
define('PROMOTION_TYPE_LAST_MINUTE', 3);

/*
|--------------------------------------------------------------------------
| Payment data config
|--------------------------------------------------------------------------
|
*/
//define('PAYMENT_SECURE_SECRET', "18D7EC3F36DF842B42E1AA729E4AB010");
//define('PAYMENT_VIRTUAL_CLIENT_URL', "http://mtf.onepay.vn/vpcpay/vpcpay.op");

define('PAYMENT_SECURE_SECRET', "3B790B26842539FDC7B792893259ECE9");
define('PAYMENT_VIRTUAL_CLIENT_URL', "https://onepay.vn/vpcpay/vpcpay.op");

define('INVOICE_NOT_PAID', 0);

define('INVOICE_SUCCESSFUL', 1);

define('INVOICE_PENDING', 2);

define('INVOICE_FAILED', 3);

define('INVOICE_UNKNOWN', 4);

/**
 * Booking Status & Reservation Status
 */

define('BOOKING_NEW', 1);
define('BOOKING_PENDING', 2);
define('BOOKING_DEPOSIT', 3);
define('BOOKING_FULL_PAID', 4);
define('BOOKING_CANCEL', 5);
define('BOOKING_CLOSE_WIN', 6);
define('BOOKING_CLOSE_LOST', 7);


define('HOTEL_CHILDREN_RATE', 75);

define('VISA_PAYMENT_NOTIFICATION_EMAIL', 'visabestprice@gmail.com');
define('FLIGHT_PAYMENT_NOTIFICATION_EMAIL', 'flightreservationbestprice@gmail.com');

/**
 * CONSTANT FOR FLIGHT MODULE
 */


define('FLIGHT_AGENT_CODE', "BSP");

define('FLIGHT_SECURITY_CODE', "PMxca4v5wm366LwMbqCVwI26aywDXoLiyjx1BMnebo");

define('FLIGHT_V_HASH', 2);

define('FLIGHT_LANG', 'en');

define('FLIGHT_TYPE_DEPART', 'depart');

define('FLIGHT_TYPE_RETURN', 'return');

define('FLIGHT_SEARCH_CRITERIA', 'flight_search_criteria_front_end');

define('FLIGHT_TYPE_ROUNDWAY','roundway');

define('FLIGHT_TYPE_ONEWAY','oneway');

define('FLIGHT_BOOKING_INFO','flight_booking_info');

define('VNISC_VIEW_STATE','/wEPDwUJMTU5NzMyNTQxZGQ=');


define('FLIGHT_WEB_SERVICE_URL', 'http://webservice.muadi.vn/OTHBookingProcess.asmx?WSDL');

define('FLIGHT_WEB_SERVICE_AGENT', 'WS_BSP');

define('FLIGHT_WEB_SERVICE_SECURITY_CODE', 'iyMr95mX2NVYa1VnOG3kECOWR74u//YVYV61Zne704');

define('FLIGHT_PROCESS_CONTINUE', '<!--ProcessContinue-->');

define('FLIGHT_PROCESS_COMPLETED', '<!--ProcessCompleted-->');

define('FLIGHT_PROCESS_WAITING', 'WAITING');

define('FLIGHT_CURL_ERROR', 'FLIGHT_CURL_ERROR');

define('FLIGHT_ERROR_TM','ERROR-TM');

define('FLIGHT_ERROR_UN', 'ERROR-UN');

define('FLIGHT_PASSENGER_LIMIT', 9);

define('FLIGHT_BOOKING_SESSISON_DATA', 'flight_booking_session_data');

define('FLIGHT_VNISC_SID', 'flight_vnisc_sid');

define('FLIGHT_ERROR_INTERNAL', 'ERROR_INTERNAL');

define('FLIGHT_NO_FLIGHT', 'NO_FLIGHT');

define('FLIGHT_MAX_ADULTS', 10);

define('FLIGHT_MAX_CHILDREN', 10);

define('FLIGHT_MAX_INFANTS', 5);

define('FLIGHT_SEARCH_DATA', 'flight_search_data');
/*
|--------------------------------------------------------------------------
| Voucher & Promotion config
|--------------------------------------------------------------------------
|
*/

define('SESSION_PROMOTION_CAMPAIGN', 'cp_promo');

define('CAMPAIGN_FREE_VISA', 'CAMPAIGN_FREE_VISA');

define('CAMPAIGN_VOUCHER', 'CAMPAIGN_VOUCHER');


define('FREE_VISA_RATE', '12');


/**
 * I18n Functions
 */
define('I18N_SINGLE_MODE', 1);

define('I18N_MULTIPLE_MODE', 2);

/*
|--------------------------------------------------------------------------
| Partner
|--------------------------------------------------------------------------
|
*/
define('PARTNER_BEST_PRICE_VIETNAM', 1);

/*
|--------------------------------------------------------------------------
| Registration
|--------------------------------------------------------------------------
|
*/
define('REGISTRATION_TAX_NUMBER', 0104679428);


/*
 |--------------------------------------------------------------------------
| New constants of 2015 Version
|--------------------------------------------------------------------------
|
*/
define('MOBILE_ON_OFF', 'MOBILE_ON_OFF');


/*
 * BEGIN NEWS CONSTANTS OF BESTPRICE 2015
 |--------------------------------------------------------------------------
| CONSTANTS OF PAGES
| ex: HOME_PAGE, TOUR_DESTINATION_PAGE
|--------------------------------------------------------------------------
|
*/
define('HOME_PAGE', 'HOME_PAGE');
define('VN_TOUR_PAGE', 'tours');
define('VN_HOTEL_PAGE', 'hotels');
define('VN_FLIGHT_PAGE', 'flights');

define('HALONG_CRUISE_PAGE', 'halongbaycruises');

define('LUXURY_HALONG_CRUISE_PAGE', 'luxuryhalongcruises');
define('DELUXE_HALONG_CRUISE_PAGE', 'deluxehalongcruises');
define('CHEAP_HALONG_CRUISE_PAGE', 'cheaphalongcruises');
define('CHARTER_HALONG_CRUISE_PAGE', 'privatehalongcruises');
define('DAY_HALONG_CRUISE_PAGE', 'halongbaydaycruises');

define('FAMILY_HALONG_CRUISE_PAGE', 'halongfamilycruises');
define('HONEY_MOON_HALONG_CRUISE_PAGE', 'halonghoneymooncruises');

define('HALONG_BAY_BIG_SIZE_CRUISE_PAGE', 'halongbigsizecruises');
define('HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE', 'halongmediumsizecruises');
define('HALONG_BAY_SMALL_SIZE_CRUISE_PAGE', 'halongsmallsizecruises');

define('MEKONG_CRUISE_PAGE', 'mekongrivercruises');

define('VIETNAM_CAMBODIA_CRUISE_PAGE', 'mekongcruisesvietnamcambodia');
define('VIETNAM_CRUISE_PAGE', 'mekongcruisesvietnam');
define('LAOS_CRUISE_PAGE', 'mekongcruiseslaos');
define('THAILAND_CRUISE_PAGE', 'mekongcruisesthailand');
define('BURMA_CRUISE_PAGE', 'mekongcruisesburma');

define('LUXURY_MEKONG_CRUISE_PAGE', 'luxurymekongcruises');
define('DELUXE_MEKONG_CRUISE_PAGE', 'deluxemekongcruises');
define('CHEAP_MEKONG_CRUISE_PAGE', 'cheapmekongcruises');
define('PRIVATE_MEKONG_CRUISE_PAGE', 'privatemekongcruises');
define('DAY_MEKONG_CRUISE_PAGE', 'mekongriverdaycruises');

define('ADVERTISING_PAGE', 'ADVERTISING_PAGE');
define('ADVERTISING_PROMOTION_ADS_PAGE', 'ADVERTISING_PROMOTION_ADS_PAGE');
define('ADVERTISING_BOOK_TOGETHER_PAGE', 'ADVERTISING_BOOK_TOGETHER_PAGE');
define('ADVERTISING_FREE_VISA_APPLICABLE_PAGE', 'ADVERTISING_FREE_VISA_APPLICABLE_PAGE');
define('ADVERTISING_GIFT_VOUCHER_PAGE', 'ADVERTISING_GIFT_VOUCHER_PAGE');
define('ADVERTISING_VISA_FOR_FRIENDS_PAGE', 'ADVERTISING_VISA_FOR_FRIENDS_PAGE');
define('ADVERTISING_BOOKING_TOGETHER_PAGE', 'ADVERTISING_BOOKING_TOGETHER_PAGE');

define('DEAL_OFFER_PAGE', 'deals');
define('VN_VISA_PAGE', 'vietnam-visa');
define('VN_VISA_APPLY_PAGE', 'vietnam-visa/apply-visa.html');
define('VN_VISA_DETAILS_PAGE', 'vietnam-visa/visa-details.html');
define('VN_VISA_FOR_CITIZENS_PAGE', 'visa_for_citizens');
define('VN_VISA_REQUIREMENTS_PAGE', 'vietnam-visa/visa-requirements.html');
define('VN_VISA_APPLICATION_PAGE', 'vietnam-visa/visa-application.html');
define('VN_VISA_PAYMENT_PAGE', 'vietnam-visa/payment.html');
define('VN_VISA_FEES_PAGE', 'vietnam-visa/visa-fees.html');
define('VN_VISA_ON_ARRIVAL_PAGE', 'vietnam-visa/visa-on-arrival.html');
define('VN_VISA_HOW_TO_APPLY_PAGE', 'vietnam-visa/how-to-apply.html');
define('VN_VISA_EMBASSIES_WORLDWIDE_PAGE', 'vietnam-visa/vietnam-embassies.html');
define('VN_VISA_AVAILABILITY_FEE_PAGE', 'vietnam-visa/vietnam-visa-availability-and-fee.html');
define('VN_VISA_EXEMPTION_PAGE', 'vietnam-visa/vietnam-visa-exemption.html');
define('VN_VISA_TYPES_PAGE', 'vietnam-visa/visa-types.html');

define('TOP_TOURS_PAGE', 'Top_%s-Tours');
define('TOURS_BY_DESTINATION_PAGE', 'Tours_%s-Tours');
define('TOURS_BY_TRAVEL_STYLE_PAGE', 'Tours_%s_%s-Tours');
define('TOUR_DETAIL_PAGE', 'Tour_%s.html');
define('TOUR_BOOKING_PAGE', 'tour-booking/%s.html');

define('TOUR_BOOK_IT_PAGE', 'tour-book-it/%s.html');
define('TOUR_ADD_CART_PAGE', 'tour-add-cart/%s/%s');

define('TOUR_REVIEW_PAGE', 'Tour_%s.html/Reviews');

define('TOUR_SEARCH_PAGE', 'tour-search.html');
define('TOUR_SEARCH_EMPTY_PAGE', 'tour-search-empty.html');

define('TOUR_SEARCH_HISTORY', 'TOUR_SEARCH_HISTORY');
define('HOTEL_SEARCH_HISTORY', 'HOTEL_SEARCH_HISTORY');

define('CRUISE_DETAIL_PAGE', 'Cruise_%s.html');
define('CRUISE_REVIEW_PAGE', 'Cruise-Reviews_%s.html');

define('FAQ_PAGE', 'faqs');
define('FAQ_DESTINATION_PAGE', 'Faqs-Destination_%s.html');
define('FAQ_CATEGORY_PAGE', 'Faqs-Category_%s.html');
define('FAQ_DETAIL_PAGE', 'Faqs_%s.html');

define('DESTINATION_DETAIL_PAGE', 'Destination_%s.html');
define('DESTINATION_THINGS_TO_DO_PAGE', 'Thing-To-Do_%s.html');
define('DESTINATION_THINGS_TODO_DETAIL_PAGE', 'Things-To-Do_%s_%s.html');
define('DESTINATION_ATTRACTION_PAGE', 'Attraction_%s.html');
define('DESTINATION_CITY_IN_COUNTRY', 'City-in_%s.html');
define('DESTINATION_INFORMATION_PAGE', 'Information_%s_%s.html');
define('DESTINATION_ARTICLE_PAGE', 'Article_%s.html');
define('DESTINATION_ARTICLE_DETAIL_PAGE', 'Article_%s_%s.html');

define('HOTEL_DETAIL_PAGE','Hotel_%s.html');
define('HOTEL_BOOK_IT_PAGE', 'hotel-book-it/%s.html');
define('HOTEL_ADD_CART_PAGE', 'hotel-add-cart/%s/%s');
define('HOTELS_BY_DESTINATION_PAGE', 'Hotels_%s-Hotels');
define('HOTEL_BOOKING_PAGE', 'hotel-booking/%s.html');

define('HOTEL_SEARCH_PAGE', 'hotel-search.html');
define('HOTEL_SEARCH_EMPTY_PAGE', 'hotel-search-empty.html');

define('HOTEL_REVIEW_PAGE', 'Hotel-Reviews_%s.html');

define('ABOUT_US_PAGE', 'aboutus');
define('REGISTRATION_PAGE', 'aboutus/registration');
define('POLICY_PAGE', 'policy');
define('PRIVACY_PAGE', 'policy/privacy');
define('OUR_TEAM_PAGE', 'our-team');
define('CONTACT_US_PAGE', 'aboutus/contact');

define('MY_BOOKING_PAGE', 'my-booking');
define('SUBMIT_BOOKING_PAGE', 'submit-booking');

define('BOOK_TOGETHER_PAGE', 'book-together');


define('THANK_YOU_PAGE', 'thank-you.html');
define('THANK_YOU_REQUEST_PAGE', 'thank-you-request.html');

define('CUSTOMIZE_TOUR_PAGE', 'customize-tours');

define('REVIEW_PAGE', 'Review_%s.html');

define('PAYMENT_SUCCESS_PAGE', 'PAYMENT_SUCCESS_PAGE');
define('PAYMENT_PENDING_PAGE', 'PAYMENT_PENDING_PAGE');
define('PAYMENT_UNSUCCESS_PAGE', 'PAYMENT_UNSUCCESS_PAGE');


define('DESTINATION_ATTRACTION_MAX_LIST', 6);
define('DESTINATION_THING_TO_DO_MAX_LIST', 6);
/*
|--------------------------------------------------------------------------
| CONSTANTS OF ADVERISE
| Ad-pages & Ad-area
|--------------------------------------------------------------------------
|
*/
define('AD_AREA_DEFAULT', 0);
define('AD_AREA_2', 1);
define('AD_AREA_3', 2);

define('AD_PAGE_HOME', 1);
define('AD_PAGE_VIETNAM_TOUR', 2);
define('AD_PAGE_TOUR_BY_DESTINATION', 3);
define('AD_PAGE_VIETNAM_HOTEL', 4);
define('AD_PAGE_HOTEL_BY_DESTINATION', 5);
define('AD_PAGE_VIETNAM_FLIGHT',6);
define('AD_PAGE_FLIGHT_BY_DESTINATION',7);
define('AD_PAGE_HALONG_BAY_CRUISE',8);
define('AD_PAGE_MEKONG_RIVER_CRUISE',9);
define('AD_PAGE_VIETNAM_VISA',10);
define('AD_PAGE_DEAL_OFFER',11);
define('AD_PAGE_TOUR_BY_TRAVEL_STYLES', 12);
define('AD_PAGE_LUXURY_HALONG_CRUISE', 13);
define('AD_PAGE_MID_RANGE_HALONG_CRUISE', 14);
define('AD_PAGE_BUDGET_HALONG_CRUISE', 15);
define('AD_PAGE_PRIVATE_HALONG_CRUISE', 16);
define('AD_PAGE_BIG_SIZE_HALONG_CRUISE', 17);
define('AD_PAGE_MEDIUM_SIZE_HALONG_CRUISE', 18);
define('AD_PAGE_SMALL_SIZE_HALONG_CRUISE', 19);
define('AD_PAGE_VIETNAM_CAMBODIA_MEKONG_CRUISE', 20);
define('AD_PAGE_VIETNAM_MEKONG_CRUISE', 21);
define('AD_PAGE_LAOS_MEKONG_CRUISE', 22);
define('AD_PAGE_THAILAN_MEKONG_CRUISE', 23);
define('AD_PAGE_BURMA_MEKONG_CRUISE', 24);
define('AD_PAGE_LUXURY_MEKONG_CRUISE', 25);
define('AD_PAGE_MEKONG_DAY_CRUISE', 26);
define('AD_PAGE_HALONG_FAMILY_CRUISES', 27);
define('AD_PAGE_HALONG_BAY_DAY_CRUISES', 28);
define('AD_PAGE_DELUXE_MEKONG_CRUISES', 29);
define('AD_PAGE_CHEAP_MEKONG_CRUISES', 30);
define('AD_PAGE_PRIVATE_MEKONG_CRUISES', 31);
define('AD_PAGE_HALONGBAY_HONEYMOON_CRUISES', 32);

define('AD_DISPLAY_SINGLE', 1);
define('AD_DISPLAY_MULTIPLE', 2);

/*
|--------------------------------------------------------------------------
| CONSTANTS OF SYSTEM LIMITATION
|--------------------------------------------------------------------------
|
*/

define('CHECK_RATE_MONTH_LIMIT', 18); // month limitation of 18 months

/*
 |--------------------------------------------------------------------------
| CONSTANTS OF LANGUAGE ID
|--------------------------------------------------------------------------
|
*/
define('LANG_ID_EN', 1);
define('LANG_ID_ES', 2);
define('LANG_ID_FR', 3);

/*
 |--------------------------------------------------------------------------
| CONSTANTS OF TOUR CATEGORY & TYPE
|--------------------------------------------------------------------------
|
*/

define('TOUR_CATEGORY_LAND_TOUR', 1);
define('TOUR_CATEGORY_CRUISE_TOUR', 2);
define('TOUR_TYPE_PRIVATE', 1);
define('TOUR_TYPE_GROUP', 2);

/*
 |--------------------------------------------------------------------------
| CONSTANTS OF HOTEL
|--------------------------------------------------------------------------
|
*/
define('HOTEL_DESTINATION', 'hotel/hotels/hotels_by_destination/');

/*
 |--------------------------------------------------------------------------
 | CONSTANTS OF USER ACTION
 |--------------------------------------------------------------------------
 |
*/
define('ACTION_CHECK_RATE', 'check_rate');
define('ACTION_BOOK', 'book');
define('ACTION_ADD_CART', 'add_cart');
define('ACTION_BACK', 'back');
define('ACTION_NEXT', 'next');
define('ACTION_DELETE', 'delete');
define('ACTION_SUBMIT', 'submit');
define('ACTION_CHECKOUT', 'check_out');
define('ACTION_UPDATE', 'update');
define('ACTION_PAY', 'pay');

/*
 |--------------------------------------------------------------------------
 | CONSTANTS OF CRUISE_TYPES
 |--------------------------------------------------------------------------
*/
define('CRUISE_TYPE_SHARING', 1);
define('CRUISE_TYPE_PRIVATE', 2);
define('CRUISE_TYPE_DAY', 3);
define('CRUISE_TYPE_FAMILY', 4);
define('CRUISE_TYPE_HONEYMOON', 5);
define('CRUISE_TYPE_VIETNAM_CAMBODIA', 6);
define('CRUISE_TYPE_VIETNAM', 7);
define('CRUISE_TYPE_LAOS', 8);
define('CRUISE_TYPE_THAILAND', 9);
define('CRUISE_TYPE_BURMA', 10);

/*
|--------------------------------------------------------------------------
| FAQ PAGE INDEX
|--------------------------------------------------------------------------
*/

define('FAQ_PAGE_HALONG_CRUISE',  1);
define('FAQ_PAGE_LUXURY_HALONG_CRUISE',   2);
define('FAQ_PAGE_MID_RANGE_HALONG_CRUISE',   3);
define('FAQ_PAGE_BUDGET_HALONG_CRUISE',   4);
define('FAQ_PAGE_PRIVATE_HALONG_CRUISE',   5);
define('FAQ_PAGE_DAY_HALONG_CRUISE',   6);
define('FAQ_PAGE_BIG_SIZE_HALONG_CRUISE',   7);
define('FAQ_PAGE_MEDIUM_SIZE_HALONG_CRUISE',   8);
define('FAQ_PAGE_SMALL_SIZE_HALONG_CRUISE',   9);
define('FAQ_PAGE_HONNEY_MOON_HALONG_CRUISE',   10);
define('FAQ_PAGE_HALONG_CRUISE_DETAIL',   11);
define('FAQ_PAGE_HALONG_TOUR_DETAIL', 12);


define('FAQ_PAGE_MEKONG_CRUISE',   20);
define('FAQ_PAGE_VIETNAM_CAMBODIA_MEKONG_CRUISE',   21);
define('FAQ_PAGE_VIETNAM_MEKONG_CRUISE',   22);
define('FAQ_PAGE_LAOS_MEKONG_CRUISE',   23);
define('FAQ_PAGE_THAILAND_MEKONG_CRUISE',   24);
define('FAQ_PAGE_BURMA_MEKONG_CRUISE',   25);
define('FAQ_PAGE_MEKONG_CRUISE_DETAIL',   26);
define('FAQ_PAGE_MEKONG_TOUR_DETAIL',   27);

define('FAQ_PAGE_VN_HOTEL_PAGE',   40);
define('FAQ_PAGE_HOTEL_BY_DESTINATION', 41);
define('FAQ_PAGE_HOTEL_DETAIL',   42);
define('FAQ_PAGE_HOTEL_SEARCH',   43);
define('FAQ_PAGE_HOTEL_BOOKING',   44);


define('FAQ_PAGE_VN_TOUR',   60);
define('FAQ_PAGE_TOUR_BY_DESTINATION',   61);
define('FAQ_PAGE_TOUR_DETAIL',   62);
define('FAQ_PAGE_TOUR_SEARCH',   63);
define('FAQ_PAGE_TOUR_BOOKING',   64);

define('FAQ_PAGE_VN_FLIGHT',   80);
define('FAQ_PAGE_FLIGHT_BY_DESTINATION',   81);
define('FAQ_PAGE_FLIGHT_BY_AIRLINE',   82);
define('FAQ_PAGE_FLIGHT_BY_TYPE',   83);
define('FAQ_PAGE_FLIGHT_SEARCH',  84);
define('FAQ_PAGE_FLIGHT_PASSENGER_DETAIL',   85);
define('FAQ_PAGE_FLIGHT_BOOKING_SUBMIT',   86);

define('FAQ_PAGE_MY_BOOKING', 100);
define('FAQ_PAGE_MY_BOOKING_SUBMIT', 101);
define('FAQ_PAGE_DEAL_OFFER', 102);


define('FAQ_PAGE_VN_VISA', 120);
define('FAQ_PAGE_VISA_ON_ARRIVAL', 121);
define('FAQ_PAGE_VISA_FEE', 122);
define('FAQ_PAGE_VISA_HOW_APPLY', 123);
define('FAQ_PAGE_VISA_INFORMATION', 134);


/*
 |--------------------------------------------------------------------------
 | DESTINATION TYPE
 |--------------------------------------------------------------------------
 */
define('DESTINATION_TYPE_CONTINENT', 1);
define('DESTINATION_TYPE_REGION', 2);
define('DESTINATION_TYPE_COUNTRY', 3);
define('DESTINATION_TYPE_CITY', 4);
define('DESTINATION_TYPE_DISTRICT', 5);
define('DESTINATION_TYPE_AREA', 6);
define('DESTINATION_TYPE_ATTRACTION', 7);
define('DESTINATION_TYPE_CRUISE', 8);
define('DESTINATION_TYPE_AIRPORT', 10);
define('DESTINATION_TYPE_TRAIN_STATION', 11);
define('DESTINATION_TYPE_BUS_STOP', 12);
define('DESTINATION_TYPE_SHOPPING_AREA', 20);
define('DESTINATION_TYPE_HERITAGE', 21);
define('DESTINATION_TYPE_LAND_MARK', 22);

/*
 |--------------------------------------------------------------------------
 | CONSTANTS OF TEXT LIMITATION
 |--------------------------------------------------------------------------
 */
define('TOUR_SHORT_DESCRIPTION_LENGTH', 300);
define('CRUISE_SHORT_DESCRIPTION_LENGTH', 220);
define('HOTEL_SHORT_DESCRIPTION_LENGTH', 220);

define('MOBILE_CRUISE_SHORT_DESCRIPTION_LENGTH', 60);

/*
 |--------------------------------------------------------------------------
 | PHOTO FOLDERS
 |--------------------------------------------------------------------------
 */
define('PHOTO_FOLDER_TOUR', 'tours');

define('PHOTO_FOLDER_CRUISE', 'cruises');

define('PHOTO_FOLDER_ACTIVITY', 'activities');

define('PHOTO_FOLDER_ARTICLE', 'articles');

define('PHOTO_FOLDER_DESTINATION', 'destinations');

define('PHOTO_FOLDER_DESTINATION_USEFUL_INFORMATION', 'useful_information');

define('PHOTO_FOLDER_DESTINATION_SERVICE', 'destination_services');

define('PHOTO_FOLDER_ADVERTISE', 'advertises');

define('PHOTO_FOLDER_HOTEL', 'hotels');

define('PHOTO_FOLDER_HOME', 'homes');

define('PHOTO_FOLDER_TRAVEL_STYLE', 'travel_styles');

define('PHOTO_FOLDER_DESTINATION_TRAVEL_STYLE', 'destination_travel_styles');

/*
 |--------------------------------------------------------------------------
 | SORT BY
 |--------------------------------------------------------------------------
 */

define('SORT_BY_RECOMMEND', 'recommended');
define('SORT_BY_PRICE_LOW_HIGH', 'price_low_high');
define('SORT_BY_PRICE_HIGH_LOW', 'price_high_low');
define('SORT_BY_REVIEW_SCORE', 'review_score');
define('SORT_BY_STAR_5_1', 'stars_5_1');
define('SORT_BY_STAR_1_5', 'stars_1_5');

/*
 |--------------------------------------------------------------------------
 | VISA
 |--------------------------------------------------------------------------
 */
define('VISA_BOOKING_DETAILS', 'last_visa_details');


/*
 |--------------------------------------------------------------------------
 | module
 |--------------------------------------------------------------------------
 */
define('MODULE_TOUR', 'tour');

define('MODULE_HOTEL', 'hotel');

/*
 |--------------------------------------------------------------------------
 | Define Destination ID
 |--------------------------------------------------------------------------
 */
define('DESTINATION_VIETNAM', 235);

/*
 * Search display mode
 * */

define('VIEW_PAGE_HOME', 1);
define('VIEW_PAGE_ADVERTISE', 2);
define('VIEW_PAGE_NOT_ADVERTISE', 3);
define('VIEW_PAGE_DEAL', 4);

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */