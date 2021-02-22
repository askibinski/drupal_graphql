<?php

namespace Drupal\drupal_custom\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;

/**
 * Provides resolvers for the content-type page.
 *
 * @SchemaExtension(
 *   id = "drupal_custom_page",
 *   name = "Page extension",
 *   description = "Adds resolvers the content-type page.",
 *   schema = "composable"
 * )
 */
class PageExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) {

  }

}
