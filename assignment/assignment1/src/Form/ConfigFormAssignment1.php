<?php

/**
 * @file
 * Contains \Drupal\assignment1\Form\ConfigFormAssignment1.
 */

namespace Drupal\assignment1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class ConfigFormAssignment1 extends ConfigFormBase {
   /**
* {@inheritdoc}.
*/
public function getEditableConfigNames() {
  return [
    'assignment1_config.settings',
  ];
}
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
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('assignment1_configdata.settings');
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Full Name.'),
      '#default_value' => $config->get('name'),
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your email address.'),
      '#default_value' => $config->get('email'),
    ];
    $form['comment'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Your Comment.'),
      '#default_value' => $config->get('comment'),
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

    $config = \Drupal::configFactory()->getEditable('assignment1_configdata.settings');
    //$config = $this->config('assignment1_configdata.settings');
    $config->set('name', $form_state->getValue('name'));
    $config->set('email', $form_state->getValue('email'));
    $config->set('comment', $form_state->getValue('comment'));
    $config->save();

    $name = $form_state->getValue('name');
    $form_state->setRedirect("assignment1_thankyou",array("name" => $name));
     parent::submitForm($form, $form_state);
     drupal_set_message($this->t('Your111 email address is @email', ['@email' => $form_state->getValue('email')]));
  }
}

