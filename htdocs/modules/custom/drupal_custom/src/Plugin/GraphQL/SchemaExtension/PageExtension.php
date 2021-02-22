<?php

namespace Drupal\drupal_custom\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\node\NodeInterface;
use GraphQL\Error\Error;

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
    $builder = new ResolverBuilder();

    // Resolve nodeByID Query.
    $registry->addFieldResolver('Query', 'nodeByID',
      $builder->produce('entity_load')
        ->map('type', $builder->fromValue('node'))
        ->map('id', $builder->fromArgument('id'))
    );

    // Resolve nodeByPath Query.
    $registry->addFieldResolver('Query', 'nodeByPath',
      $builder->compose(
        $builder->produce('route_load')
          ->map('path', $builder->fromArgument('path')),
        $builder->produce('route_entity')
          ->map('url', $builder->fromParent())
      )
    );

    // The Page entity (node) id.
    $registry->addFieldResolver('Page', 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );

    // The Page entity title.
    $registry->addFieldResolver('Page', 'title',
      $builder->produce('entity_label')
        ->map('entity', $builder->fromParent())
    );

    // The Page url alias.
    $registry->addFieldResolver('Page', 'slug',
      $builder->compose(
        $builder->produce('entity_url')
          ->map('entity', $builder->fromParent()),
        $builder->produce('url_path')
          ->map('url', $builder->fromParent()),
      )
    );

    $registry->addFieldResolver('Page', 'route',
      $builder->compose(
        $builder->produce('entity_url')
          ->map('entity', $builder->fromParent()),
        $builder->produce('url_path')
          ->map('url', $builder->fromParent()),
      )
    );

    // The author name.
    $registry->addFieldResolver('Page', 'author',
      $builder->compose(
        $builder->produce('entity_owner')
          ->map('entity', $builder->fromParent()),
        $builder->produce('entity_label')
          ->map('entity', $builder->fromParent())
      )
    );

    // The paragraph content field (see ParagraphExtension).
    $registry->addFieldResolver('Page', 'content',
      $builder->produce('entity_reference_revisions')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_paragraph_content'))
    );

    $registry->addTypeResolver('NodeInterface', function ($value) {
      if ($value instanceof NodeInterface) {
        switch ($value->bundle()) {
          case 'page':
            return 'Page';

            // Other content-types...
        }
      }

      throw new Error('Could not resolve content type: ' . $value->bundle());
    });

  }

}
