<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\musicworldform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use Drupal\Core\Link;
 
/**
 * Provides route responses for the Example module.
 */
class MusicWorldAlbumForm extends ControllerBase {
 
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function successpage() {
  //display thankyou page
    $element = array(
      '#markup' => 'Album Form data submitted',
    );
    return $element;
  }
 
  public function getJson($json = TRUE) {
  //fetch data from employee table.
  $db = \Drupal::database(); 
  $query = $db->select('albumform', 'n'); 
  $query->fields('n'); 
  $response = $query->execute()->fetchAll();
  if ($jsone) {
    return new JsonResponse( $response );
  }
  else {
    return $response;
  }
    
  }
  
  public function getDetails() {
    $header = [
      'firstName' => [
        'data' => t('First Name'),
        'field' => 'firstName',
        'class' => [
          'left'
        ],
      ],
      'lastName' => [
        'data' => t('Last Name'),
        'field' => 'lastName',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'email' => [
        'data' => t('Email'),
        'field' => 'email',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'album' => [
        'data' => t('Instrested Album'),
        'field' => 'album',
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
     ];
     $formData = $this->getJson(False);
     foreach($formData as $form) {
       $row['firstName'] = $form->first_name;
       $row['lastName'] = $form->last_name;
       $row['email'] = $form->email;
       if (!empty($form->album)) {
         $node = Node::load($form->album);
         $title = $node->getTitle();
         $url = Url::fromUserInput("/node/{$form->album}");
         $albumLinks = Link::fromTextAndUrl($this->t($title), $url)->toString();
         //$node = \Drupal\node\Entity\Node::load($form->album);
       }
       $row['album'] = $albumLinks;
       $rows[] = $row;
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