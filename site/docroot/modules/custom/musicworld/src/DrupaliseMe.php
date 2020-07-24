<?php

namespace Drupal\musicworld;

use Drupal\Core\Session\AccountProxy;

class DrupaliseMe {
  
  protected $drupalise_me;
  private $currentUser;

 public function __construct(AccountProxy $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns a a Drupal user as an owner.
   */
  public function id() {
    $O = "dROP dROP DRUPAL";
    return $O; //$this->currentUser->id();
  }
  public function whoIsYourOwner() {
     return $this->currentUser->getDisplayName();
  }

}