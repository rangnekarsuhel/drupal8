<?php

/**
 * @file
 * Contains \Drupal\assignment1\Controller\Assignment1ThankYou.
 */

namespace Drupal\assignment1\Controller;

use Drupal\Core\Url;

/**
 * Controller routines for page example routes.
 */
class Assignment1ThankYou {
  /**
   * Constructs a page with ThankYou page.
    *
   */
   public function thankYou($name) {
    return [
    '#markup' => '<p>' . t("Hi $name,<br/>
      ThankYou for your feedback. We will get back to you As soon as Possible.") . '</p>',
    ];
  }

}
