<?php

namespace Drupal\drupal_custom\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\paragraphs\ParagraphInterface;
use GraphQL\Error\Error;

/**
 * Provides resolvers for the paragraphs.
 *
 * @SchemaExtension(
 *   id = "drupal_custom_paragraph",
 *   name = "Paragraph extension",
 *   description = "Adds resolvers the paragraphs.",
 *   schema = "composable"
 * )
 */
class ParagraphExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) {
    $builder = new ResolverBuilder();

    $registry->addFieldResolver('ParagraphTextAndImage', 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );

    $registry->addFieldResolver('ParagraphTextAndImage', 'text',
      $builder->fromPath('entity:paragraph:text_and_image', 'field_text.value')
    );

    $registry->addFieldResolver('ParagraphTextAndImage', 'image',
      $builder->produce('entity_reference')
        ->map('entity', $builder->fromParent())
        ->map('field', $builder->fromValue('field_image'))
    );

    $registry->addTypeResolver('ParagraphInterface', function ($value) {
      if ($value instanceof ParagraphInterface) {
        switch ($value->bundle()) {
          case 'text_and_image':
            return 'ParagraphTextAndImage';

          case 'call_to_action':
            return 'ParagraphCallToAction';

            // Other paragraph types...
        }
      }

      throw new Error('Could not resolve paragraph type: ' . $value->bundle());
    });

  }

}
