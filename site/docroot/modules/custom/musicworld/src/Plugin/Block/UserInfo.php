<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\musicworld\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\musicworld\UserService;


/**
 * Provides a 'User Info' block.
 *
 * @Block(
 * id = "user_info",
 * admin_label = @Translation("User Info"),
 * )
 */
class UserInfo extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var $drupalise \Drupal\musicworld\UserService
   */
  protected $userService;
  
  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\musicworld\UserService $user_service
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, UserService $user_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    //$service = \Drupal::service('musicworld.user_service');
    $this->userService = $user_service;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('musicworld.user_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $userInfo .= "<div>User Name: {$this->userService->getDisplayName()}</div>";
    $userInfo .= "<div>User Email: {$this->userService->getEmail()}</div>";
    $build = [];
    $build['current_user_info_block']['#markup'] = $userInfo;

    return $build;
  }

}