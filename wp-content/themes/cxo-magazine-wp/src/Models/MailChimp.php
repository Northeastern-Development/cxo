<?php
/**********************
 *
 * MailChimp Newsletter
 *
 * ***************/

namespace CXO\Models;

class MailChimp {

  public function __construct($api_key, $api_endpoint, $list_id) {
    $this->api_key = $api_key;
    $this->api_endpoint = $api_endpoint;
    $this->list_id  = $list_id;
  }

  public function post($args = array()) {

    if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
      throw new \Exception("cURL support is required, but can't be found.");
    }

    $url = 'https://'. $this->api_endpoint .'.api.mailchimp.com/3.0' . '/lists/' . $this->list_id . '/members';
    $httpHeader = array(
                    'Accept: application/vnd.api+json',
                    'Content-Type: application/vnd.api+json',
                    'Authorization: apikey ' . $this->api_key
                  );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));

    $responseContent = curl_exec($ch);

    curl_close($ch);

    return $responseContent;
  }
}
