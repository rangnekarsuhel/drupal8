<?php

/**
 * @file
 * Contains \Drupal\assignment1\Plugin\Block\Assignment1BlockConfig.
 */

namespace Drupal\assignment1\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Example: empty block' block.
 *
 * @Block(
 *   id = "Assignment1BlockConfig",
 *   admin_label = @Translation("Assignment1 Config Block form")
 * )
 */
class Assignment1BlockConfig extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form =  \Drupal::formBuilder()->getForm('Drupal\assignment1\Form\ConfigFormAssignment1');
    return $form;
  }

}
