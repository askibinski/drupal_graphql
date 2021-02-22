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

    // The image style urls.
    $this->addMediaImageStyleUrlField($registry, $builder, 'Image', 'image_url_small', 'content_small');
    $this->addMediaImageStyleUrlField($registry, $builder, 'Image', 'image_url_large', 'content_large');

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

  /**
   * Adds a graphql field resolver for a specific image style.
   *
   * @param \Drupal\graphql\GraphQL\ResolverRegistryInterface $registry
   *   The resolver registry.
   * @param \Drupal\graphql\GraphQL\ResolverBuilder $builder
   *   The resolver builder.
   * @param string $type
   *   The graphql Type.
   * @param string $field
   *   The desired graphql field name.
   * @param string $image_style
   *   The machine name of the image style to be used.
   */
  protected function addMediaImageStyleUrlField(ResolverRegistryInterface $registry, ResolverBuilder $builder, $type, $field, $image_style) {
    $registry->addFieldResolver($type, $field,
      $builder->compose(
      // Load the file object from the field.
        $builder->produce('property_path')
          ->map('type', $builder->fromValue('entity:paragraph'))
          ->map('value', $builder->fromParent())
          ->map('path', $builder->fromValue('field_media_image.target_id')),
        $builder->produce('entity_load')
          ->map('type', $builder->fromValue('file'))
          ->map('id', $builder->fromParent()),
        // Load the image style derivative of the file.
        $builder->produce('image_derivative')
          ->map('entity', $builder->fromParent())
          ->map('style', $builder->fromValue($image_style)),
        // Retrieve the url of the generated image.
        $builder->produce('image_style_url')
          ->map('derivative', $builder->fromParent()),
      )
    );
  }

}
