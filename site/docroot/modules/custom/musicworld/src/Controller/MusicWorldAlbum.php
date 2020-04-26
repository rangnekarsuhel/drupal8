<?php

/**
 * @file
 * Contains \Drupal\musicworld\Controller\MusicWorldAlbum.
 */

namespace Drupal\musicworld\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\views\Views;


/**
 * Page for Music Album.
 */
class MusicWorldAlbum extends ControllerBase {
  
   public function album() {  
    $view = Views::getView('album');
    $view->setDisplay('block_album_listing');
    //$view->setArguments([$entity->id()]);;
    $build = $view->render();
    $job_fairs_view = \Drupal::service('renderer')->render($build);

    $content['message'] = [
      '#markup' => $job_fairs_view,
    ];

    return $content;
  }
  
  public function topalbum() {   
          
    $view = Views::getView('album');
    $view->setDisplay('block_top_albums_listing');
    //$view->setArguments([$entity->id()]);;
    $build = $view->render();
    $job_fairs_view = \Drupal::service('renderer')->render($build);

    $content['message'] = [
      '#markup' => $job_fairs_view,
    ];

    return $content;
  }
  

}
