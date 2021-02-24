<?php

namespace Drupal\drupal_custom\Plugin\GraphQL\DataProducer;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\graphql\Plugin\GraphQL\DataProducer\DataProducerPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The Image url producer.
 *
 * @DataProducer(
 *   id = "media_image_url",
 *   name = @Translation("Media image url"),
 *   description = @Translation("The media image url."),
 *   produces = @ContextDefinition("string",
 *     label = @Translation("Media image url")
 *   ),
 *   consumes = {
 *     "uri" = @ContextDefinition("string",
 *       label = @Translation("Language"),
 *       required = FALSE
 *     ),
 *   }
 * )
 */
class MediaImageUrl extends DataProducerPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The stream wrapper manager.
   *
   * @var \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface
   */
  protected StreamWrapperManagerInterface $streamWrapperManager;

  /**
   * Header constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $stream_wrapper_manager
   *   The stream wrapper manager.
   */
  public function __construct(array $configuration, string $plugin_id, array $plugin_definition, StreamWrapperManagerInterface $stream_wrapper_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->streamWrapperManager = $stream_wrapper_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('stream_wrapper_manager')
    );
  }

  /**
   * Returns an absolute url for a file scheme.
   *
   * @param string|null $uri
   *   The uri.
   *
   * @return string
   *   The absolute url.
   */
  public function resolve(?string $uri): string {
    $wrapper = $this->streamWrapperManager->getViaUri($uri);
    return $wrapper->getExternalUrl();
  }

}
