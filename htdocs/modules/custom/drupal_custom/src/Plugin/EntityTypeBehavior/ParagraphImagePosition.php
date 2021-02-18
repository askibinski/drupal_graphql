<?php

namespace Drupal\drupal_custom\Plugin\EntityTypeBehavior;

use Drupal\entity_type_behaviors\EntityTypeBehaviorBase;

/**
 * Class ParagraphImagePosition.
 *
 * @package Drupal\drupal_custom\Plugin\EntityTypeBehavior
 *
 * @EntityTypeBehavior(
 *  id="custom_paragraphs_image_position",
 *  description="This defines the positioning of an image within a paragraph.",
 *  label=@Translation("Image position"),
 *  entityTypes={"paragraph"}
 * )
 */
class ParagraphImagePosition extends EntityTypeBehaviorBase {

  /**
   * Define the image positions.
   */
  protected const POSITION_ABOVE = 'above';
  protected const POSITION_BELOW = 'below';
  protected const POSITION_LEFT = 'left';
  protected const POSITION_RIGHT = 'right';

  /**
   * Defines the position an image can have in paragraphs.
   *
   * @var array
   */
  protected $positions;

  /**
   * {@inheritdoc}
   */
  public function getForm(): array {
    return [
      'image_position' => [
        '#type' => 'select',
        '#options' => $this->getImagePositionOptions(),
        '#title' => $this->t('Image position'),
        '#description' => $this->t('Position of the image relative to the text.'),
        '#default_value' => $this->getValueByKey('image_position') ?? [],
      ],
    ];
  }

  /**
   * Get the available options for the image position setting.
   *
   * @return array
   *   List of values with corresponding labels.
   */
  protected function getImagePositionOptions(): array {
    $options = ['context' => 'Image position'];
    return [
      static::POSITION_ABOVE => $this->t('Above', [], $options),
      static::POSITION_BELOW => $this->t('Below', [], $options),
      static::POSITION_LEFT => $this->t('Left', [], $options),
      static::POSITION_RIGHT => $this->t('Right', [], $options),
    ];
  }

}
