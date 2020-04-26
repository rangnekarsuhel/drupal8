<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\nse_stockapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class NseStockConfigForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'nse_stockapi.config';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'nse_stockapi_admin_config';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

  $form['stock_symbol'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Stock Symbol'),
      '#default_value' => $config->get('stock_symbol'),
      '#description' => "Add Symbol each on new line",
    ];

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('stock_symbol', $form_state->getValue('stock_symbol'))
      // You can set multiple configurations at once by making
      // multiple calls to set().
      ->set('other_things', $form_state->getValue('other_things'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}