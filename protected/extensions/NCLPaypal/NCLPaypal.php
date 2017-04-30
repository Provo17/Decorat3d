<?php

class NCLPaypal extends CApplicationComponent {

    protected $params = array();
    protected $client, $ns, $PayPal;
    public $Sandbox = true;
    public $APIUsername = '';
    public $APIPassword = '';
    public $APISignature = '';
    public $PrintHeaders = false;
    public $LogResults = false;
    public $LogPath = '';
    public $error_msg = '';
    public $profile_id = '';
    public $status = '';
    public $response = [];

    public function init()
    {
        require_once('paypal/autoload.php');

        $PayPalConfig = array(
            'Sandbox' => $this->Sandbox, //$sandbox,
            'APIUsername' => $this->APIUsername,
            'APIPassword' => $this->APIPassword,
            'APISignature' => $this->APISignature,
            'PrintHeaders' => $this->PrintHeaders,
            'LogResults' => $this->LogResults,
            'LogPath' => $this->LogPath,
        );

        $this->PayPal = new angelleye\PayPal\PayPal($PayPalConfig);
    }

    public function createProfile(array $data)
    {
        $DaysTimestamp = strtotime('now');
        $Mo = date('m', $DaysTimestamp);
        $Day = date('d', $DaysTimestamp);
        $Year = date('Y', $DaysTimestamp);
        $StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';
        $ProfileDetails = array(
            'subscribername' => $data['subscribername'], // Full name of the person receiving the product or service paid for by the recurring payment.  32 char max.
            'profilestartdate' => $StartDateGMT, // Required.  The date when the billing for this profile begins.  Must be a valid date in UTC/GMT format.
            'profilereference' => ''      // The merchant's own unique invoice number or reference ID.  127 char max.
        );
        $ScheduleDetails = array(
            'desc' => $data['desc'], // Required.  Description of the recurring payment.  This field must match the corresponding billing agreement description included in SetExpressCheckout.
            'maxfailedpayments' => '', // The number of scheduled payment periods that can fail before the profile is automatically suspended.
            'autobillamt' => '1'       // This field indicates whether you would like PayPal to automatically bill the outstanding balance amount in the next billing cycle.  Values can be: NoAutoBill or AddToNextBilling
        );

        $BillingPeriod = array(
            'trialbillingperiod' => '',
            'trialbillingfrequency' => '',
            'trialtotalbillingcycles' => '',
            'trialamt' => '',
            'billingperiod' => 'Month', // Required.  Unit for billing during this subscription period.  One of the following: Day, Week, SemiMonth, Month, Year
            'billingfrequency' => '1', // Required.  Number of billing periods that make up one billing cycle.  The combination of billing freq. and billing period must be less than or equal to one year.
            'totalbillingcycles' => '0', // the number of billing cycles for the payment period (regular or trial).  For trial period it must be greater than 0.  For regular payments 0 means indefinite...until canceled.
            'amt' => $data['amt'], // Required.  Billing amount for each billing cycle during the payment period.  This does not include shipping and tax.
            'currencycode' => 'USD', // Required.  Three-letter currency code.
            'shippingamt' => '', // Shipping amount for each billing cycle during the payment period.
            'taxamt' => ''         // Tax amount for each billing cycle during the payment period.
        );
        $CCDetails = array(
            'creditcardtype' => $data['creditcardtype'], // Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
            'acct' => $data['acct'], // Required.  Credit card number.  No spaces or punctuation.
            'expdate' => $data['expdate'], // Required.  Credit card expiration date.  Format is MMYYYY
            'cvv2' => $data['cvv2'], // Requirements determined by your PayPal account settings.  Security digits for credit card.
            'startdate' => isset($data['startdate']) ? $data['startdate'] : '', // Month and year that Maestro or Solo card was issued.  MMYYYY
            'issuenumber' => isset($data['issuenumber']) ? $data['issuenumber'] : ''// Issue number of Maestro or Solo card.  Two numeric digits max.
        );

        $PayerInfo = array(
            'email' => $data['email'], // Email address of payer.
            'payerid' => '', // Unique PayPal customer ID for payer.
            'payerstatus' => '', // Status of payer.  Values are verified or unverified
            'countrycode' => '', // Payer's country of residence in the form of the two letter code.
            'business' => ''        // Payer's business name.
        );

        $PayerName = array(
            'salutation' => '', // Payer's salutation.  20 char max.
            'firstname' => $data['fname'], // Payer's first name.  25 char max.
            'middlename' => '', // Payer's middle name.  25 char max.
            'lastname' => $data['lname'], // Payer's last name.  25 char max.
            'suffix' => ''        // Payer's suffix.  12 char max.
        );

        $BillingAddress = array(
            'street' => $data['street'], // Required.  First street address.
            'street2' => '', // Second street address.
            'city' => $data['city'], // Required.  Name of City.
            'state' => $data['state'], // Required. Name of State or Province.
            'countrycode' => $data['countrycode'], // Required.  Country code.
            'zip' => $data['zip'], // Required.  Postal code of payer.
            'phonenum' => ''       // Phone Number of payer.  20 char max.
        );
        $PayPalRequestData = array(
            'ProfileDetails' => $ProfileDetails,
            'ScheduleDetails' => $ScheduleDetails,
            'BillingPeriod' => $BillingPeriod,
            'CCDetails' => $CCDetails,
            'PayerInfo' => $PayerInfo,
            'PayerName' => $PayerName,
            'BillingAddress' => $BillingAddress
        );

        $PayPalResult = $this->PayPal->CreateRecurringPaymentsProfile($PayPalRequestData);
        return $this->process_response($PayPalResult);
    }

    public function getProfileStatus($profile_id)
    {
        // Prepare request arrays
        $GRPPDFields = ['profileid' => $profile_id];   // Profile ID of the profile you want to get details for.
        $PayPalRequestData = ['GRPPDFields' => $GRPPDFields];
        // Pass data into class for processing with PayPal and load the response array into $PayPalResult
        $PayPalResult = $this->PayPal->GetRecurringPaymentsProfileDetails($PayPalRequestData);
        return $this->process_response($PayPalResult);
    }

    protected function process_response($PayPalResult)
    {
        $this->response = $PayPalResult;
        if (isset($PayPalResult['ACK']) && $PayPalResult['ACK'] == 'Success')
        {
            switch ($PayPalResult['REQUESTDATA']['METHOD'])
            {
                case 'CreateRecurringPaymentsProfile':
                    $this->status = $PayPalResult['PROFILESTATUS'];
                    $this->profile_id = $PayPalResult['PROFILEID'];
                    break;
                case 'GetRecurringPaymentsProfileDetails':
                    $this->status = $PayPalResult['STATUS'];
                    break;
            }
        }
        else
        {
            $this->status = 'error';
            if (isset($PayPalResult['ERRORS'][0]['L_LONGMESSAGE']))
            {
                $this->error_msg = $PayPalResult['ERRORS'][0]['L_LONGMESSAGE'];
            }
            else
            {
                $this->error_msg = 'Unknown error';
            }
        }
        return !($this->status == 'error');
    }

}

