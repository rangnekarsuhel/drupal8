<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\musicworldform\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
 
class AlbumForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'album_form';
  }
 
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#pattern' => '[A-Za-z]+',
      '#required' => TRUE,
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#pattern' => '[A-Za-z]+',
      '#required' => TRUE,
    );
    $form['email_address'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email:'),
      '#pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$',
      '#required' => TRUE,
    );
    $album_opts = musicworld_load_entity_field_name('album', 'title');
    $form['album'] = array (
      '#type' => 'select',
      '#title' => ('Interest in Album'),
      '#options' => $album_opts,
    );
 
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $conn = Database::getConnection();
    $conn->insert('albumform')->fields(
      array(
        'first_name' => $form_state->getValue('first_name'),
        'last_name' => $form_state->getValue('last_name'),
        'email' => $form_state->getValue('email_address'),
        'album' => $form_state->getValue('album'),
      )
    )->execute();
    $url = Url::fromRoute('album.thankyou');
    $form_state->setRedirectUrl($url);
   }
 
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //$email = $form_state->getValue('email_address');
 
  }
}