<?php

/**
 * @file
 * Contains \Drupal\assignment1\Plugin\Block\Assignment1Block.
 */

namespace Drupal\assignment1\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Example: empty block' block.
 *
 * @Block(
 *   id = "Assignment1Block",
 *   admin_label = @Translation("Assignment 1 Blcok form")
 * )
 */
class Assignment1Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form =  \Drupal::formBuilder()->getForm('Drupal\assignment1\Form\Assignment1');
    return $form;
  }

}
