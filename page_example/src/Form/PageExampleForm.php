<?php

/**
 * @file
 * Contains \Drupal\page_example\Form\PageExampleForm.
 */

namespace Drupal\page_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class PageExampleForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'page_example_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('page_example.settings');
    //\Drupal::config('ime.settings')->get('ime_pages'),
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your .com email address.'),
      '#default_value' => $config->get('email_address')
      //'#default_value' => \Drupal::config('ime.settings')->get('ime_pages')
    ];
    $form['title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title'),
    '#default_value' => $config->get('address.line_1'),
    '#weight' => 0,
  );
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
    //$config = $this->config('page_example.settings');
    //$config = $this->configFactory->getEditable('page_example.settings');
    //$config->set('email_address', $form_state->getValue('email'));
    //$config->save();
    //$form_state->setRedirect("page_example_arguments",array("name" => $name));
    //return parent::submitForm($form, $form_state);
    //parent::submitForm($form, $form_state);
  }

}

