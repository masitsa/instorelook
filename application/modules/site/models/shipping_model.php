<?php
class Shipping_model extends CI_Model
{
	private $api = 'https://auspost.com.au/api/';
	private $auth_key = 'e4687449-6f9f-4570-9deb-2192d1128c7a';
    const MAX_HEIGHT = 35; //only applies if same as width
	const MAX_WIDTH = 35; //only applies if same as height
	const MAX_WEIGHT = 20; //kgs
	const MAX_LENGTH = 105; //cms
	const MAX_GIRTH = 140; //cms
	const MIN_GIRTH = 16; //cms
 
    public function getRemoteData($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Auth-Key: ' . $this->auth_key
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$contents = curl_exec ($ch);
		curl_close ($ch);
		return json_decode($contents,true);
	}
 
    public function getShippingCost($data)
	{
		$edeliver_url = "{$this->api}postage/parcel/domestic/calculate.json";
		$edeliver_url = $this->arrayToUrl($edeliver_url,$data);		
		$results = $this->getRemoteData($edeliver_url);
 
		if (isset($results['error']))
		{
			throw new Exception($results['error']['errorMessage']);
			return $results['error']['errorMessage'];
		}
		
		else
 		{
			return $results['postage_result']['total_cost'];
		}
	}
 
    public function arrayToUrl($url,$array)
	{
		$first = true;
		foreach ($array as $key => $value)
		{
			$url .= $first ? '?' : '&';
			$url .= "{$key}={$value}";
			$first = false; 	
		}	
		return $url;
	}
 
    public function getGirth($height,$width)
	{
		return ($width+$height)*2;
	}
	
	public function create_shipment()
	{
		$apiKey = "9677f556-1b48-4b37-80ec-849bec104327";
		$accountNumber="Your Account Number";

		// Set the URL for the Shipping Service
		$urlPrefix = "digitalapi.auspost.com.au";
		$url = "http://" + $urlPrefix + "/testbed/shipping/v1/shipments";
		
		$params = "{\n"
. "   \"shipments\":[\n"
. "      {\n"
. "        \"shipment_reference\":\"Shipment 1 reference\",  \n"
. "        \"customer_reference_1\":\"cr1 - 234\",\n"
. "         \"customer_reference_2\":\"cr2 - 345\",\n"
. "         \"from\":{\n"
. "           \"name\":\"Mr Package Sender\",\n"
. "            \"lines\":[\n"
. "               \"1341 Dandenong Road\"\n"
. "            ],\n"
. "            \"suburb\":\"Melb\",\n"
. "            \"postcode\":\"3148\",\n"
. "            \"state\":\"VIC\"          \n"
. "         },\n"
. "         \"to\":{\n"
. "            \"name\":\"Mr Package Reciever\",\n"
. "            \"business_name\":\"No-one's Business\",\n"
. "            \"lines\":[\n"
. "               \"Lvl 11\",\n"
. "               \"123 smith st 100\"\n"
. "            ],\n"
. "            \"suburb\":\"Greensborough\",\n"
. "            \"state\":\"VIC\",\n"
. "            \"postcode\":\"3088\",\n"
. "            \"phone\":\"0356567567\"\n"
. "         },\n"
. "         \"items\":[\n"
. "            {\n"
. "               \"length\":\"10\",\n"
. "               \"height\":\"10\",\n"
. "               \"width\":\"10\",\n"
. "               \"weight\":\"10\",\n"
. "               \"item_reference\":\"Item Ref 1\",\n"
. "               \"product_id\":\"T28S\",\n"
. "              \"authority_to_leave\":false,\n"
. "              \"partial_delivery_allowed\":true\n"
. "            },\n"
. "           {\n"
. "               \"length\":\"10\",\n"
. "               \"height\":\"10\",\n"
. "               \"width\":\"10\",\n"
. "               \"weight\":\"10\",\n"
. "               \"item_reference\":\"Item Ref 2\",\n"
. "               \"product_id\":\"T28S\",\n"
. "               \"authority_to_leave\":false,\n"
. "               \"partial_delivery_allowed\":true\n"
. "            },\n"
. "            {\n"
. "               \"length\":\"10\",\n"
. "               \"height\":\"10\",\n"
. "               \"width\":\"10\",\n"
. "               \"weight\":\"10\",\n"
. "               \"item_reference\":\"Item Ref 3\",\n"
. "               \"product_id\":\"T28S\",\n"
. "               \"authority_to_leave\":false,\n"
. "               \"partial_delivery_allowed\":true\n"
. "            }\n"
. "         ]\n"
. "      },\n"
. "      {\n"
. "         \"shipment_reference\":\"My second shipment ref\",  \n"
. "         \"customer_reference_1\":\"s2cr1\",\n"
. "         \"customer_reference_2\":\"s2cr2\",\n"
. "         \"from\":{\n"
. "            \"name\":\"Mr Other Sender\",\n"
. "            \"lines\":[\n"
. "               \"1341 Dandenong Road\"\n"
. "            ],\n"
. "            \"suburb\":\"Melb\",\n"
. "            \"postcode\":\"3148\",\n"
. "            \"state\":\"VIC\"\n"
. "          \n"
. "         },\n"
. "         \"to\":{\n"
. "            \"name\":\"Mrs Other Reciever\",\n"
. "            \"business_name\":\"Their Business Pty Ltd\",\n"
. "            \"lines\":[\n"
. "               \"Lvl 22\",\n"
. "               \"124 Smith St\"\n"
. "            ],\n"
. "            \"suburb\":\"Greensborough\",\n"
. "            \"state\":\"VIC\",\n"
. "            \"postcode\":\"3088\",\n"
. "            \"phone\":\"0322222222\"\n"
. "         },\n"
. "         \"items\":[\n"
. "            {\n"
. "               \"length\":\"10\",\n"
. "               \"height\":\"10\",\n"
. "               \"width\":\"10\",\n"
. "               \"weight\":\"10\",\n"
. "               \"item_reference\":\"S2 IR1\",\n"
. "               \"product_id\":\"T28S\",\n"
. "               \"authority_to_leave\":false,\n"
. "               \"partial_delivery_allowed\":true\n"
. "            },\n"
. "            {\n"
. "               \"length\":\"12\",\n"
. "               \"height\":\"12\",\n"
. "               \"width\":\"12\",\n"
. "               \"weight\":\"12\",\n"
. "               \"item_reference\":\"S2 IR2\",\n"
. "               \"product_id\":\"T28S\",\n"
. "               \"authority_to_leave\":false,\n"
. "               \"partial_delivery_allowed\":true\n"
. "            },\n"
. "            {\n"
. "               \"length\":\"13\",\n"
. "               \"height\":\"13\",\n"
. "               \"width\":\"13\",\n"
. "               \"weight\":\"13\",\n"
. "               \"item_reference\":\"S2 IR3\",\n"
. "               \"product_id\":\"T28S\",\n"
. "               \"authority_to_leave\":false,\n"
. "               \"partial_delivery_allowed\":true\n"
. "            }\n"
. "         ]\n"
. "      }\n"
. "   ]\n"
. "}";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  "Authorization: Basic ".$apiKey,
		  //"account-number: ".$accountNumber
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$contents = curl_exec ($ch);
		curl_close ($ch);
		return json_decode($contents,true);
		
/*request.setEntity(params);
//Set correct HTTP Headers
request.addHeader("Content-Type", "application/json");
request.addHeader("Authorization", "Basic ".new String(Base64.encodeBase64(apiKey.getBytes())));
request.addHeader("account-number", accountNumber);

HttpResponse response = httpclient.execute(request);

// Check the response: if the body is empty then an error occurred
if(response.getStatusLine().getStatusCode() != 201){
throw new Exception("Error: '" . response.getStatusLine().getReasonPhrase() . "' - Code: " . response.getStatusLine().getStatusCode());
}
// All good, lets see the results
System.out.println(EntityUtils.toString(response.getEntity()));*/
	}
}
?>