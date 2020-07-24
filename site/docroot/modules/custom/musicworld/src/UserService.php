<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Drupal\musicworld;

use Drupal\Core\Session\AccountProxy;

/**
 * Description of UserService
 */
class UserService {

  private $currentUser;

  /**
   * 
   */
  public function __construct(AccountProxy $currentUser) {
    $this->currentUser = $currentUser;
  }

 /**
   * {@inheritdoc}
   */
  public function getDisplayName() {
    return $this->currentUser->getDisplayName();
  }
  
  /**
   * {@inheritdoc}
   */
  public function getEmail() {
    return $this->currentUser->getEmail();
  }
  
  /**
   * {@inheritdoc}
   */
  public function getAccountName() {
    return $this->currentUser->getAccountName();
  }
  
  /**
   * {@inheritdoc}
   */
  public function getAccount() {
    return $this->currentUser->getAccount();
  }
  
  /**
   * {@inheritdoc}
   */
  public function getRoles() { 
    return $this->currentUser->getRoles();
  }
  
}