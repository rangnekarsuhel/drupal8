<?php

namespace Drupal\youtube\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests youtube field widgets and formatters.
 *
 * @group youtube
 */
class YouTubeTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['node', 'youtube', 'field_ui', 'image', 'file'];

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => 'YouTube field',
      'description' => 'Tests youtube field widgets and formatters.',
      'group' => 'YouTube',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Create Basic page and Article node types.
    if ($this->profile != 'standard') {
      $this->drupalCreateContentType(['type' => 'page', 'name' => 'Basic page']);
      $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);
    }

    $this->admin_user = $this->drupalCreateUser([
      'access content',
      'access administration pages',
      'administer site configuration',
      'administer content types',
      'administer node fields',
      'administer nodes',
      'create article content',
      'edit any article content',
      'delete any article content',
      'administer image styles',
    ]);
    $this->drupalLogin($this->rootUser);
  }

  /**
   * Test downloading a remote image.
   */
  public function testRemoteImage() {
    $field_name = mb_strtolower($this->randomMachineName());
    // Create a field.
    $field_storage = \Drupal::entityTypeManager()->getStorage('field_storage_config')->create([
      'field_name' => $field_name,
      'entity_type' => 'node',
      'translatable' => FALSE,
      'type' => 'youtube',
      'cardinality' => '1',
    ]);
    $field_storage->save();
    $field = \Drupal::entityTypeManager()->getStorage('field_config')->create([
      'field_storage' => $field_storage,
      'bundle' => 'article',
      'title' => DRUPAL_DISABLED,
    ]);
    $field->save();

    \Drupal::entityTypeManager()->getStorage('entity_form_display')->load('node.article.default')
      ->setComponent($field_name, [
        'type' => 'youtube',
        'settings' => [],
      ])
      ->save();

    \Drupal::entityTypeManager()->getStorage('entity_view_display')->load('node.article.full')
      ->setComponent($field_name, [
        'type' => 'youtube_thumbnail',
      ])
      ->save();

    // Display creation form.
    $this->drupalGet('node/add/article');
    $this->assertFieldByName("{$field_name}[0][input]", '', t('Video input field is displayed'));

    // Verify that a valid URL can be submitted.
    $video_id = 'T5y3dJYHb_A';
    $value = 'http://www.youtube.com/watch?v=' . $video_id;
    $edit = [
      "title[0][value]" => "Test1",
      "{$field_name}[0][input]" => $value,
    ];
    $this->drupalPostForm(NULL, $edit, t('Save and publish'));
    preg_match('|/node/(\d+)|', $this->url, $match);
    $this->assertText(t('Article Test1 has been created.'));

    $video_id = 'T5y3dJYHb_A';

    // Verify that the image markup is displayed.
    $matches = [];
    $subject = $this->getRawContent();
    $pattern = '/<img .*src="(.*?' . $video_id . '[\/\d+]*\.[jpg].*?)"/s';
    preg_match($pattern, $subject, $matches);
    $this->assertPattern($pattern);
    $img_url = $matches[1];

    // Verify that the remote image is created.
    $this->drupalGet($img_url);
    $this->assertResponse(200, 'Remote image downloaded');
  }

  /**
   * Test ID validation and the proper video display of a valid ID.
   */
  public function testVideo() {
    $field_name = mb_strtolower($this->randomMachineName());
    // Create a field.
    $field_storage = \Drupal::entityTypeManager()->getStorage('field_storage_config')->create([
      'field_name' => $field_name,
      'entity_type' => 'node',
      'translatable' => FALSE,
      'type' => 'youtube',
      'cardinality' => '1',
    ]);
    $field_storage->save();
    $field = \Drupal::entityTypeManager()->getStorage('field_config')->create([
      'field_storage' => $field_storage,
      'bundle' => 'article',
      'title' => DRUPAL_DISABLED,
    ]);
    $field->save();

    \Drupal::entityTypeManager()->getStorage('entity_form_display')->load('node.article.default')
      ->setComponent($field_name, [
        'type' => 'youtube',
        'settings' => [],
      ])
      ->save();

    \Drupal::entityTypeManager()->getStorage('entity_view_display')->load('node.article.full')
      ->setComponent($field_name, [
        'type' => 'youtube_video',
      ])
      ->save();

    // Display creation form.
    $this->drupalGet('node/add/article');
    $this->assertFieldByName("{$field_name}[0][input]", '', t('Video input field is displayed'));

    // Verify that a valid URL can be submitted.
    $video_id = 'T5y3dJYHb_A';
    $value = 'http://www.youtube.com/watch?v=' . $video_id;
    $embed_value = 'http://www.youtube.com/embed/' . $video_id;
    $edit = [
      "title[0][value]" => 'Test',
      "{$field_name}[0][input]" => $value,
    ];
    $this->drupalPostForm(NULL, $edit, t('Save and publish'));
    preg_match('|/node/(\d+)|', $this->url, $match);
    $this->assertText(t('Article Test has been created.'));
    $this->assertRaw($embed_value);

    // Verify that the video is displayed.
    $pattern = '<iframe.*src="' . $embed_value;
    $pattern = str_replace('/', '\/', $pattern);
    $pattern = '/' . $pattern . '/s';
    $this->assertPattern($pattern);

    // Verify that invalid URLs cannot be submitted.
    $this->drupalGet('node/add/article');
    $value = 'not-a-url';
    $edit = [
      "title[0][value]" => 'Test1',
      "{$field_name}[0][input]" => $value,
    ];
    $this->drupalPostForm(NULL, $edit, t('Save and publish'));
    $this->assertText(t('Please provide a valid YouTube URL.'));
  }

}
