<?php

namespace Drupal\nse_stockapi;

class ServiceStockFetchData {
  
  protected $nseStockAPI;
  protected $nseStockAPIReferer;

  public function __construct() {
    // API
    $this->nseStockAPI = "https://nseindia.com/api/quote-equity";
  }

  /**
   * Get the Stock data from NSE API.
   *
   * @param string symbol
   *
   * @return array
   */
  public function getStockData($symbol) {
    $output = array();
    $headers = [
      'Accept' => 'application/json',
      'Cache-Control' => 'no-cache',
    ];
    
    if (!empty($symbol)) {
      $client = \Drupal::httpClient();
      $request = $client->get($this->nseStockAPI, array(
        'headers' => $headers,
        //'debug' => true,
        'query' => ['symbol' => $symbol],
      ));
      $output['code'] = $request->getStatusCode();
      $output['result'] = $request->getBody()->getContents();
      return $output;
    }
  }

}