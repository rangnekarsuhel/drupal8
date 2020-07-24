<?php
/**
 * @file
 * Contains \Drupal\musicworldcarousel\Plugin\Block\PoweredBy.
 */

namespace Drupal\musicworldcarousel\Plugin\Block;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "waltzerjs_carousel_block",
 *   admin_label = @Translation("WaltzerjsCarousel Block"),
 *   category = @Translation("Custom")
 * )
 */
class WaltzerjsCarousel extends BlockBase {
/**
   * {@inheritdoc}
   */
  public function build() {
   /* $tag = '{"slidesToShow": 4, "slidesToScroll": 4}"';
    $data = "<div class='slick-track' data-slick='{$tag}'>
  <div class='slick-slide' ><h3>1</h3></div>
  <div class='slick-slide' ><h3>2</h3></div>
  <div class='slick-slide' ><h3>3</h3></div>
  <div class='slick-slide' ><h3>4</h3></div>
  <div class='slick-slide' ><h3>5</h3></div>
  <div class='slick-slide' ><h3>6</h3></div>
</div>";*/
    
    
    $build = [];
 $myArrayofObjects = array(
      1 => array('name' => 'suhel', 'email' => 's@g.com'),
      2 => array('name' => 'omkar', 'email' => 'o@g.com'),
    );
    //$myArrayofObjects = array('suhe', 'Inaaya');
    $title = "New Carosul Block";
    
    //$style = \Drupal::entityTypeManager()->getStorage('image_style')->load('thumbnail');
    //$url = $style->buildUrl('public://my-image.png');
    $artist_opts = musicworldcarousel_load_entity_field_name('album', 'field_image');
    $build['myelement'] = [
      '#theme' => 'waltzerjs_carousel',
      '#title' => $artist_opts,
    ];
    /*$build['myelement'] = [
      '#markup' => 'Testing'
    ];*/

    return $build;
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
