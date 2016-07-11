<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * type: 
 * 		1 - Visa
 * 		2 - Flight
 */
function get_payment_url($invoice) {

    $CI =& get_instance();
    $CI->config->load('payment_meta');
    $pay_parameter = $CI->config->item('pay_parameter');
    
    $again_link = site_url()."vietnam-visa/";
    if($invoice['type'] == FLIGHT) { // for flight
    	$again_link = site_url().FLIGHT_HOME;
    }

    // set timezone
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    ksort($pay_parameter);

    // set a parameter to show the first pair in the URL
    $appendAmp = 0;

    // Create the request to the Virtual Payment Client which is a URL encoded GET
    // request. Since we are looping through all the data we may as well sort it in
    // case we want to create a secure hash and add it to the VPC data if the
    // merchant secret has been provided.
    $md5HashData = "";

    $vpcURL = PAYMENT_VIRTUAL_CLIENT_URL ."?";
    
    $customer = $invoice['customer'];

    foreach ($pay_parameter as $key => $value) {

        switch ($key) {
            case "vpc_Amount":
                $value = $invoice['amount'] * 100;
                break;
            case "vpc_ReturnURL":
                $value = site_url()."payment/";
                break;
            case "vpc_MerchTxnRef":
                $value = date('YmdHis') . rand();
                break;
            case "AgainLink":
                $value = site_url();
                break;
            case "vpc_OrderInfo":
                $value = $invoice['invoice_reference'];
                break;
            case "vpc_TicketNo":
            	if(isset($customer['ip_address'])) {
            		$value = $customer['ip_address'];
            	}
                break;
            case "vpc_Customer_Id":
                $value = $customer['id'];
                break;
            case "vpc_Customer_Email":
                $value = $customer['email'];
                break;
            case "vpc_Customer_Phone":
                $value = $customer['phone'];
                break;
            case "vpc_SHIP_Country":
                $value = strtoupper($customer['country']);
                break;
            case "vpc_SHIP_City":
                $value = $customer['city'];
                break;
            case "AVS_Country":
                $value = strtoupper($customer['country']);
                break;
            case "AVS_City":
                $value = $customer['city'];
                break;
        }

        // create the md5 input and URL leaving out any fields that have no value
        if (strlen($value) > 0) {

            // this ensures the first parameter of the URL is preceded by the '?' char
            if ($appendAmp == 0) {
                $vpcURL .= urlencode($key) . '=' . urlencode($value);
                $appendAmp = 1;
            } else {
                $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
            }
            //$md5HashData .= $value; use both name and value to encrypt
            if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                $md5HashData .= $key . "=" . $value . "&";
            }
        }
    }

    //remove "&" character in the end of encryption string
    $md5HashData = rtrim($md5HashData, "&");

    // Create the secure hash and append it to the Virtual Payment Client Data if
    // the merchant secret has been provided.
    if (strlen(PAYMENT_SECURE_SECRET) > 0) {
        $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',PAYMENT_SECURE_SECRET)));
    }

    return $vpcURL;
}


function getResponseData() {
	
	$CI =& get_instance();
	// get and remove the vpc_TxnResponseCode code from the response fields as we
	$vpc_Txn_Secure_Hash = isset($_GET["vpc_SecureHash"]) ? $_GET["vpc_SecureHash"] : '';
	
	// do not want to include this field in the hash calculation
	unset($_GET["vpc_SecureHash"]);
		
	if (strlen(PAYMENT_SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
			
		ksort($_GET);
			
		$md5HashData = "";
		// sort all the incoming vpc response fields and leave out any with no value
		foreach ($_GET as $key => $value) {
			if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
				$md5HashData .= $key . "=" . $value . "&";
			}
		}
		//  Remove "&" unnecessary character
		$md5HashData = rtrim($md5HashData, "&");
			
		if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',PAYMENT_SECURE_SECRET)))) {
			// Secure Hash validation succeeded, add a data field to be displayed
			// later.
			$hashValidated = "CORRECT";
		} else {
			// Secure Hash validation failed, add a data field to be displayed
			// later.
			$hashValidated = "INVALID HASH";
		}
	} else {
		// Secure Hash was not validated, add a data field to be displayed later.
		$hashValidated = "INVALID HASH";
	}
		
	// Define Variables
	// ----------------
	// Extract the available receipt fields from the VPC Response
	// If not present then let the value be equal to 'No Value Returned'
		
	// Standard Receipt Data
	$amount = null2unknown($_GET["vpc_Amount"]);
	$orderInfo = null2unknown($_GET["vpc_OrderInfo"]);
	$txnResponseCode = null2unknown($_GET["vpc_TxnResponseCode"]);
	$againLink = null2unknown($_GET["AgainLink"]);
	
	// card information
	$card_type = isset($_GET["vpc_Card"]) ? null2unknown($_GET["vpc_Card"]) : '';
	$commercial_card = isset($_GET["vpc_CommercialCard"]) ? null2unknown($_GET["vpc_CommercialCard"]) : '';
	$card_num = isset($_GET["vpc_CardNum"]) ? null2unknown($_GET["vpc_CardNum"]) : '';
	
	return array(
			'amount' => $amount, 
			'orderInfo' => $orderInfo, 
			'txnResponseCode' => $txnResponseCode, 
			'hashValidated' => $hashValidated,
			'againLink' => $againLink,
			'card_type' => get_card_type($card_type, $commercial_card),
			'card_num' => $card_num,
	);
}


// This method uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//
function getResponseDescription($responseCode)
{

    switch ($responseCode) {
        case "0" :
            $result = "Transaction Successful";
            break;
        case "?" :
            $result = "Transaction status is unknown";
            break;
        case "1" :
            $result = "Bank system reject";
            break;
        case "2" :
            $result = "Bank Declined Transaction";
            break;
        case "3" :
            $result = "No Reply from Bank";
            break;
        case "4" :
            $result = "Expired Card";
            break;
        case "5" :
            $result = "Insufficient funds";
            break;
        case "6" :
            $result = "Error Communicating with Bank";
            break;
        case "7" :
            $result = "Payment Server System Error";
            break;
        case "8" :
            $result = "Transaction Type Not Supported";
            break;
        case "9" :
            $result = "Bank declined transaction (Do not contact Bank)";
            break;
        case "A" :
            $result = "Transaction Aborted";
            break;
        case "C" :
            $result = "Transaction Cancelled";
            break;
        case "D" :
            $result = "Deferred transaction has been received and is awaiting processing";
            break;
        case "F" :
            $result = "3D Secure Authentication failed";
            break;
        case "I" :
            $result = "Card Security Code verification failed";
            break;
        case "L" :
            $result = "Shopping Transaction Locked (Please try the transaction again later)";
            break;
        case "N" :
            $result = "Cardholder is not enrolled in Authentication scheme";
            break;
        case "P" :
            $result = "Transaction has been received by the Payment Adaptor and is being processed";
            break;
        case "R" :
            $result = "Transaction was not processed - Reached limit of retry attempts allowed";
            break;
        case "S" :
            $result = "Duplicate SessionID (OrderInfo)";
            break;
        case "T" :
            $result = "Address Verification Failed";
            break;
        case "U" :
            $result = "Card Security Code Failed";
            break;
        case "V" :
            $result = "Address Verification and Card Security Code Failed";
            break;
        case "99" :
            $result = "User Cancel";
            break;
        default  :
            $result = "Unable to be determined";
    }
    return $result;
}


// If input is null, returns string "No Value Returned", else returns input
function null2unknown($data)
{
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}

function _send_mail_payment($subject, $mail_content, $mail_attachment, $to) {

	$CI =& get_instance();
	
	$separator = md5(time());
	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;
	
	// -- body and headers
	$header = 'From: ' . BRANCH_NAME.' <reservation@'.strtolower(SITE_NAME).'>'. "\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;

	// --- content
	$message = $mail_content;
	
	$body = "Content-Transfer-Encoding: 7bit".$eol;
	$body .= "This is a MIME encoded message.".$eol; //had one more .$eol
	
	// message
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
	$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$body .= $message.$eol; //had one more .$eol

	// --- attachment
	$filename  = $mail_attachment['name'];
	$file_path = $mail_attachment['path'];
	
	$attachment = chunk_split(base64_encode(file_get_contents($file_path)));
		
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
	$body .= "Content-Transfer-Encoding: base64".$eol;
	$body .= "Content-Disposition: attachment".$eol.$eol;
	$body .= $attachment.$eol.$eol;
	$body .= "--".$separator."--";


	// --- send to customer
	if (mail($to, $subject, $body, $header)) {
		//echo "mail send ... OK"; exit();
	} else {
		log_action('Confirm Mail', 'send failed', 'To: '.$to.' - attachment: '.$filename);
	}
}

function _send_mail_payment_notification($data, $for) {

	$CI =& get_instance();

	$separator = md5(time());
	// carriage return type (we use a PHP end of line constant)
	$eol = PHP_EOL;
	
	$to = PAYMENT_NOTIFICATION_EMAIL;
	
	$invoice = $data['invoice'];
	$subject = 'Invoice '.$for.' was paid successfully-Ref: '.$invoice['invoice_reference'].' for '.$invoice['customer']['full_name'];

	// -- body and headers
	$header = 'From: ' . BRANCH_NAME.' <reservation@'.strtolower(SITE_NAME).'>'. "\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;

	// --- content
	$message = $CI->load->view('common/payment/payment_notification_email', $data, TRUE);

	$body = "Content-Transfer-Encoding: 7bit".$eol;
	$body .= "This is a MIME encoded message.".$eol; //had one more .$eol

	// message
	$body .= "--".$separator.$eol;
	$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
	$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$body .= $message.$eol; //had one more .$eol
	$body .= "--".$separator."--";


	// --- send to customer
	mail($to, $subject, $body, $header);
}

/*
 * Send mail using google account
*/
function _send_mail_payment_by_google_acc($data, $attachment) {

	$CI =& get_instance();
	
	$subject_cus = 'Booking Vietnam Visa On Arrival - ' . BRANCH_NAME;

	// --- content
	$content = $CI->load->view('common/payment_success_form_mail', $data, TRUE);

	$cus = $data['invoice']['customer'];
		
	$CI->load->library('email');

	$CI->email->from('bestpricevn@gmail.com', BRANCH_NAME);
	$CI->email->to($cus['email']);
	$CI->email->subject($subject_cus);
	$CI->email->message($content);
	$CI->email->attach($attachment);
	if (!$CI->email->send()){
		log_message('error', 'Submit Booking - '.$cus['full_name'].': Can not send email to '.$cus['email']);
	}

	$CI->email->clear();
}

function log_payment($status = '', $hashValidated, $onepay_return, $invoice_amount, $type = VISA) {

	$log_txt = '';

	foreach ($_GET as $key => $value) {
		$log_txt .= $key.':'.$value.', ';
	}
	
	$for = 'VISA';
	if($type == FLIGHT) {
		$for = 'FLIGHT';
	}
	
	$balance_due = $onepay_return - $invoice_amount;
	
	$log_txt .= 'hashValidated: '.$hashValidated.',onepay_return: '.$onepay_return.',invoice_amount: '.$invoice_amount.', balance_due:'.$balance_due;

	if(empty($status)) {
		// log return parameter from Onepay
		log_message('error', '[INFO] Received '.$for.' payment results from Onepay: '.$log_txt);
	} else {
		// log when status = unknow (balance_due != 0, ...)
		log_message('error', '[DEBUG] Received unknow '.$for.' payment results from Onepay: '.$log_txt);
	}
}

function create_invoice_pdf($invoice_reference, $html) {
	$CI =& get_instance();
	
	$filename = 'Invoice_'.$invoice_reference .'.pdf';
		
	$file_path = realpath(FCPATH . $CI->config->item('invoice_path')).'/' . $filename;
	
	$pdf = $CI->dompdf_gen->pdf_create($html, '', false);
		
	write_file($file_path, $pdf);
	
	return array('name' => $filename, 'path' => $file_path);
}

function get_card_type($card_type, $commercial_card) {
	$txt_card_type = '';
	$card_type = trim($card_type);
	switch ($card_type) {
		case "AE" :
			$result = "American Express";
			break;
		case "AP" :
			$result = "American Express Corporate Purchase Card";
			break;
		case "BC" :
			$result = "Bankcard";
			break;
		case "BX" :
			$result = "Brand X";
			break;
		case "BY" :
			$result = "Brand Y";
			break;
		case "DC" :
			$result = "Diners Club";
			break;
		case "GC" :
			$result = "GAP Inc. card";
			break;
		case "XX" :
			$result = "Generic Card";
			break;
		case "JC" :
			$result = "JCB Card";
			break;
		case "MC" :
			$result = "MasterCard";
			break;
		case "VD" :
			$result = "Visa Debit Card";
			break;
		case "VC" :
			$result = "Visa Card";
			break;
		case "VP" :
			$result = "Visa Corporate Purchase Card";
			break;
		case "EB" :
			$result = "Electronic Benefits Card";
			break;
		default  :
			$result = "Unable to be determined";
	}
	
	if($result != "Unable to be determined") {
		$txt_card_type = $result;
		
		$is_commercial_card = is_commercial_card($commercial_card);
		if(!empty($is_commercial_card)) {
			$txt_card_type .= '/' . $is_commercial_card;
		}
	} else {
		$txt_card_type = $result;
	}
	
	return $txt_card_type;
}

function is_commercial_card($responseCode) {
	$responseCode = trim($responseCode);
	switch ($responseCode) {
		case "U" :
			$result = "";
			break;
		case "Y" :
			$result = "Commercial Card"; // Y
			break;
		case "N" :
			$result = "Not a Commercial Card"; // No
			break;
		default  :
			$result = "";
	}
	
	return $result;
}


