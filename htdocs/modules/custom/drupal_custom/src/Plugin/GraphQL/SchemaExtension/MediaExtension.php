<?php

namespace Drupal\drupal_custom\Plugin\GraphQL\SchemaExtension;

use Drupal\graphql\GraphQL\ResolverBuilder;
use Drupal\graphql\GraphQL\ResolverRegistryInterface;
use Drupal\graphql\Plugin\GraphQL\SchemaExtension\SdlSchemaExtensionPluginBase;
use Drupal\media\MediaInterface;
use GraphQL\Error\Error;

/**
 * Provides resolvers for media.
 *
 * @SchemaExtension(
 *   id = "drupal_custom_media",
 *   name = "Media extension",
 *   description = "Adds resolvers for media.",
 *   schema = "composable"
 * )
 */
class MediaExtension extends SdlSchemaExtensionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function registerResolvers(ResolverRegistryInterface $registry) {
    $builder = new ResolverBuilder();

    // The media id.
    $registry->addFieldResolver('Image', 'id',
      $builder->produce('entity_id')
        ->map('entity', $builder->fromParent())
    );

    // The url of the original image.
    $registry->addFieldResolver('Image', 'url',
      $builder->compose(
      // Load the file object from the field.
        $builder->fromPath('entity:media:image', 'field_media_image.target_id'),
        $builder->produce('entity_load')
          ->map('type', $builder->fromValue('file'))
          ->map('id', $builder->fromParent()),
        $builder->fromPath('entity:file', 'uri.value'),
        $builder->produce('media_image_url')->map('uri', $builder->fromParent())
      )
    );

    // The image alt text.
    $registry->addFieldResolver('Image', 'alt',
      $builder->fromPath('entity:media:image', 'field_media_image.alt')
    );

    // The image width.
    $registry->addFieldResolver('Image', 'width',
      $builder->fromPath('entity:media:image', 'field_media_image.width')
    );

    // The image height.
    $registry->addFieldResolver('Image', 'height',
      $builder->fromPath('entity:media:image', 'field_media_image.height')
    );

    // Response type resolvers. Tell GraphQL how to resolve types of a common
    // interface.
    $registry->addTypeResolver('MediaInterface', function ($value) {
      if ($value instanceof MediaInterface) {
        switch ($value->bundle()) {
          case 'image':
            return 'Image';

          // @todo rest of the media types.
        }
      }
      throw new Error('Could not resolve media type: ' . $value->bundle());
    });

  }

}
