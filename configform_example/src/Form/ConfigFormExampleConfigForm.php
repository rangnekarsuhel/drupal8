<?php

/**
 * @file
 * Contains \Drupal\configform_example\Form\ConfigFormExampleConfigForm.
 */

namespace Drupal\configform_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Form\ConfigFormBase;

//class ConfigFormExampleConfigForm extends FormBase {
class ConfigFormExampleConfigForm extends ConfigFormBase {

/**
* {@inheritdoc}.
*/
public function getEditableConfigNames() {
  //return ['configform_example.settings'];
  return [
    'configform_example1.settings'
    //'Name of yml file'
  ];
}

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'configform_example_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('configform_example1.settings');
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your .com email address.'),
      '#default_value' => $config->get('email_address')
    ];
    $form['addres_line_1'] = array(
      '#type' => 'textfield',
      '#title' => t('Address line 1'),
      '#default_value' => $config->get('address.line_1'),
      '#weight' => 0,
    );
    $form['contact'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact'),
      '#default_value' => $config->get('contact'),
      '#weight' => 0,
    );
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => $config->get('name'),
      '#weight' => 0,
    );
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
    $config = $this->config('configform_example1.settings');
    $config->set('email_address', $form_state->getValue('email'));
    $config->set('address.line_1', $form_state->getValue('addres_line_1'));
    $config->save();
    //$name = $form_state->getValue('name');


    //$config = $this->config('page_example.settings');
    //$config->set('email_address', $form_state->getValue('email'));
    //$config->save();
   parent::submitForm($form, $form_state);

   $form_state->setRedirect("page_example_arguments");
  }

}

