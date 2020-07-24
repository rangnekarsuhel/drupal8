<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Drupal\musicworld;

use Drupal\Core\Session\AccountProxyInterface ;

/**
 * Description of UserService
 */
class UserServiceV1 {

  private $currentUser;

  /**
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct(AccountProxyInterface  $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns a a Drupal user as an owner.
   */
  public function whoIsYourOwner() {
    return $this->currentUser->getDisplayName();
  }

 
}