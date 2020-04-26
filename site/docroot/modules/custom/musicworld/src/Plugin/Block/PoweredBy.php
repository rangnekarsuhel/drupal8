<?php
/**
 * @file
 * Contains \Drupal\musicworld\Plugin\Block\PoweredBy.
 */

namespace Drupal\musicworld\Plugin\Block;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "powered_by_block",
 *   admin_label = @Translation("Powered By Block"),
 *   category = @Translation("Custom")
 * )
 */
class PoweredBy extends BlockBase {
/**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => '<span>Powered by <a href="https://www.drupal.org/u/suhelrangnekar">Suhel Rangnekar</a></span>',
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['powered_by_settings'] = $form_state->getValue('powered_by_settings');
  }

}
