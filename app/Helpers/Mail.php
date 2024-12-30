<?php

namespace App\Helpers;


class Mail
{

  const API_TOKEN = "MTS-62c28b1a-707a-4282-ab84-93d35519825c"; //put ssl provided api_token here
  const SID = "MTSREQAPP"; // put ssl provided sid here
  const DOMAIN = "https://smsplus.sslwireless.com"; //api domain // example http://smsplus.sslwireless.com
 
    //Test Design
    public static function textMessageGenerator($str, $style=false)
    {
        $html = '<p style="'.$style.'">';
        $html .= $str;
        $html .= '</p>';
        return $html;
    }
    //Block Design

    /**
     * @param array $arr
     * @return string
     *
     *
     * $block = [
     * ['Total Budget', $total, ],
     * ['Budget Used', $used, ['background' => '#3273dc', 'color' => '#fff']],
     * ['Remain Balance Used', $remain, ['background' => '#278e4b', 'color' => '#fff']]
     * ];
     */
    public static function blockGenerator($arr = [])
    {

        $html = '<table style="width: 100%; margin: 10px 0px; border-collapse: collapse;">';

        $html .= '<tr>';
        $total_index = count($arr);
        foreach ($arr as $key => $data) {
            /**
             * |Total Budget|Budget Used|Remain Balance|
             **/
            $background = !empty($data[2]) ? $data[2]['background'] : '#ffdd57';
            $color = !empty($data[2]) ? $data[2]['color'] : '#000000b3';

            $html .= '<td style="width: ' . 100 / $total_index . '%">';


            $html .= '<div style="margin: 10px 0px; font-size: 20px; font-weight: bold; padding: 10px; text-align: center!important; background-color: ' . $background . '; color: ' . $color . '">';
            $html .= $data[0];
            $html .= '<br/>';
            $html .= $data[1];
            $html .= '</div>';


            $html .= '</td>';

        }
        $html .= '</tr>';
        $html .= '</table>';
        return $html;
    }

    //Table Generation One Query
    public static function tableGenerator($query, $heading = [], $ind = [], $style = false , $attr = false, $serial = false)
    {
        $countInd = count($ind);
        $total_index = count($query);
        if ($total_index > 0) {
            $tableWidth = (int)round(100 / $total_index);
        } else {
            $tableWidth = 100;
        }
        
        if($attr == false){
        		$tAttr = 'width="'. $tableWidth.'%"  style="width: ' . $tableWidth . '%; margin: 10px auto; text-align: center; border-collapse: collapse;font-size: 10px; ' . $style . '"';
        } else {
        	$tAttr = $attr;
        }
        //dd($attr);
        $html = '<table '.$tAttr.'>';
        $html .= '<tr>';
      	if($serial == 'serial'){
        	$html .= '<th style="background: #2d3748; color: #FFFFFF !important; padding: 5px;">S/N </th>';
        }
        foreach ($heading as $h) {
            $html .= '<th style="background: #2d3748; color: #FFFFFF !important; padding: 5px;">' . $h . '</th>';
        }
        $html .= '</tr>';
      
      
        foreach ($query as $k => $data) {
        	 $html .= '<tr>';
          	if($serial == 'serial'){
                $html .= '<td style="border: 1px solid #d8d6d6; padding: 8px; margin: 10px;">';              		
                $html .= ++$k;                    
                $html .= '</td>';    
            }
            foreach ($ind as $key => $index) {
                  $html .= '<td style="border: 1px solid #d8d6d6; padding: 8px; margin: 10px;">';              		
                  $html .= $data->$index;                    
                  $html .= '</td>';                
            }
            $html .= '</tr>';
        }
      
        $html .= '</table>';
        return $html;      
    }
  
      //Table Generation One Query
    public static function tableTrGenerator($query, $heading = [], $ind = [], $style = false)
    {
        $countInd = count($ind);
        $total_index = count($query);
        if ($total_index > 0) {
            $tableWidth = (int)round(100 / $total_index);
        } else {
            $tableWidth = 100;
        }
        $html = '<table width="'. $tableWidth.'%"  style="width: ' . $tableWidth . '%; margin: 10px auto; text-align: center; border-collapse: collapse;font-size: 10px; ' . $style . '">';
        $html .= '<tr>';
        foreach ($heading as $h) {
            $html .= '<th style="background: #2d3748; color: #FFFFFF !important; padding: 5px;">' . $h . '</th>';
        }
        $html .= '</tr>';
        foreach ($query as $data) {
            $html .= '<tr>';
            foreach ($ind as $index) {
                $html .= '<td style="border: 1px solid #d8d6d6; padding: 8px; margin: 10px;">' . $data->$index . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
    
    
    
  /**
   * @param $msisdn
   * @param $messageBody
   * @param $csmsId (Unique)
   */
  public static function singleSms($msisdn, $messageBody, $csmsId)
  {   
      $params = [
          "api_token" => Mail::API_TOKEN,
          "sid" => Mail::SID,
          "msisdn" => $msisdn,
          "sms" => $messageBody,
          "csms_id" => $csmsId
      ];
      $url = trim(Mail::DOMAIN, '/')."/api/v3/send-sms";
      $params = json_encode($params);

      echo Mail::callApi($url, $params);
  }


  public static function callApi($url, $params)
  {
    	//dd($params);
      $ch = curl_init(); // Initialize cURL
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($params),
          'accept:application/json'
      ));

      $response = curl_exec($ch);

      curl_close($ch);

      return $response;
  }
}
