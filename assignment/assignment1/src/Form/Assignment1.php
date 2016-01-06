<?php

/**
 * @file
 * Contains \Drupal\assignment1\Form\Assignment1.
 */

namespace Drupal\assignment1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class Assignment1 extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'config_assignment1_form11';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Full Name.')
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your email address.')
    ];
    $form['comment'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Your Comment.')
    ];
    $form['show'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strpos($form_state->getValue('email'), '.com') === FALSE) {
      $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Your email address is @email', ['@email' => $form_state->getValue('email')]));
    $name = $form_state->getValue('name');
    $form_state->setRedirect("assignment1_thankyou",array("name" => $name));
  }
}

