<?php

/**
 * @file
 * Contains \Drupal\nse_stockapi\Controller\NseStockApiController.
 */

namespace Drupal\nse_stockapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use \Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Url;
use Drupal\Core\Link;
use GuzzleHttp\Psr7\Uri;


/**
 * StockApi Controller for the stockapi module.
 */
class NseStockApiController extends ControllerBase {
 
  public function nse_stockapi_page() {
    $header = [
      'symbol' => [
        'data' => t('Symbol'),
        'field' => 'symbol',
        'class' => [
          'left'
        ],
      ],
      'name' => [
        'data' => t('Name'),
        'field' => 'name',
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
    
    $service = \Drupal::service('nse_stockapi.stock_fetch_data');
    $stock_symbol = \Drupal::config('nse_stockapi.config')->get('stock_symbol');
    $stock = preg_split('/\r\n|[\r\n]/', $stock_symbol);
    
    //$symbol = 'ZEEL';
    foreach($stock as $symbol) {
      $stock = $service->getStockData($symbol);
      if ($stock['code'] == 200) {
        $stockDataJSON = json_decode($stock['result']);

        $stockData = $stockDataJSON->priceInfo;
        $row['symbol'] = $stockDataJSON->metadata->symbol;
        $row['name'] = $stockDataJSON->info->companyName;
        $row['lastPrice'] = $stockData->lastPrice;
        $row['previousClose'] = $stockData->previousClose;
        $row['open'] = $stockData->open;
        $row['dayLow'] = $stockData->intraDayHighLow->min;
        $row['dayHigh'] = $stockData->intraDayHighLow->max;
        $row['closePrice'] = $stockData->close;
        $row['lastUpdateTime'] = $stockDataJSON->metadata->lastUpdateTime;


        $rows[] = $row;
        $url = Url::fromUserInput('/admin/config/development/nse-stock/config');
        $links = Link::fromTextAndUrl($this->t('Click here'), $url)->toString();
        $content['message'] = [
          '#markup' => $this->t("Add More Stock @link", array('@link' => $links)),
        ];
      }
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
