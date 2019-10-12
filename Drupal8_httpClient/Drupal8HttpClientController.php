<?php

/**
 * @file
 * Contains \Drupal\Drupal8_httpClient\Controller\Drupal8HttpClientController.
 */

namespace Drupal\Drupal8_httpClient\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * StockApi Controller for the stockapi module.
 */
class Drupal8HttpClientController extends ControllerBase {

  public function nse_stockapi_page() {
    // WebService API for NSE stock.
    $api_url = "https://www.nseindia.com/live_market/dynaContent/live_watch/get_quote/ajaxGetQuoteJSON.jsp";
    $api_referer = "https://www.nseindia.com/live_market/dynaContent/live_watch/get_quote/GetQuote.jsp?symbol=ZEEL";
    $headers = [
      'Accept' => 'application/json',
      'Cache-Control' => 'no-cache',
      //'Authentication' => $auth_key,
      'Referer' => $api_referer
    ];
    // Stock Symbol
    $symbol = 'ZEEL';
    if (!empty($symbol)) {
      $client = \Drupal::httpClient();
      $request = $client->get($api_url, array(
        'headers' => $headers,
        //'debug' => true,
        'query' => ['symbol' => $symbol, 'series' => 'EQ']
      ));
      $stock['code'] = $request->getStatusCode();
      $stock['result'] = $request->getBody();
    }

    $header = [
      'symbol' => [
        'data' => t('Symbol'),
        'field' => 'symbol',
        'class' => [
          'left'
        ],
      ],
      'lastPrice' => [
        'data' => t('Last'),
        'field' => 'lastPrice',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'previousClose' => [
        'data' => t('Previous Close'),
        'field' => 'previousClose',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'open' => [
        'data' => t('Open'),
        'field' => 'open',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'dayHigh' => [
        'data' => t('High'),
        'field' => 'dayHigh',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'dayLow' => [
        'data' => t('Low'),
        'field' => 'dayLow',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'closePrice' => [
        'data' => t('Close Price'),
        'field' => 'closePrice',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'lastUpdateTime' => [
        'data' => t('Time'),
        'field' => 'lastUpdateTime',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
    ];
    if ($stock['code'] == 200) {
      $stockDataJSON = json_decode($stock['result']);
      $stockData = $stockDataJSON->data;
      foreach ($stockData[0] as $key => $value) {
        switch ($key) {
          case 'symbol':
            $row[$key] = $value;
            break;
          case 'lastPrice':
            $row[$key] = $value;
            break;
          case 'previousClose':
            $row[$key] = $value;
            break;
          case 'open':
            $row[$key] = $value;
            break;
          case 'dayHigh':
            $row[$key] = $value;
            break;
          case 'dayLow':
            $row[$key] = $value;
            break;
          case 'closePrice':
            $row[$key] = $value;
            break;
        }
      }
      $rows[0] = $row;
      $rows[0]['time'] = $stockDataJSON->lastUpdateTime;
      $content['message'] = [
        '#markup' => $this->t($stockDataJSON->data[0]->companyName),
      ];
    }
    
    $content['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No entries available.'),
    ];

    return $content;
  }

}
