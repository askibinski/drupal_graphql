<?php


namespace Drupal\myprofile\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the myprofile entity class.
 *
 *
 * @ContentEntityType(
 *   id = "myprofile",
 *   label = @Translation("MyProfile"),
 *   handlers = {
 *     "list_builder" = "Drupal\myprofile\MyProfileListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider"
 *     },
 *     "form" = {
 *       "default" = "Drupal\MyProfile\Form\MyProfileEntityForm",
 *       "add" = "Drupal\MyProfile\Form\MyProfileEntityForm",
 *       "edit" = "Drupal\MyProfile\Form\MyProfileEntityForm",
 *     }
 *   },
 *   admin_permission = "administer",
 *   base_table = "myprofile",
 *   data_table = "myprofile_field_data",
 *   entity_keys = {
 *     "id" = "myprofile_id",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/myprofile/{myprofile}",
 *     "edit-form" = "/Myprofile/{myprofile}/edit",
 *     "cancel-form" = "/myprofile/{myprofile}/cancel",
 *     "collection" = "/admin/people",
 *   }
 * )
 */
class MyProfile extends ContentEntityBase implements MyProfileInterface
{

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {

    $fields['myprofile_id'] = BaseFieldDefinition::create('integer')
      ->setLabel('MyProfile Id')
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);
    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel('language code');

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel('UUID')
      ->setReadOnly(TRUE);

    $fields['gender'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Gender'))
      ->setDescription(t('The gender of the Contact entity.'))
      ->setSettings(array(
        'allowed_values' => array(
          'female' => 'female',
          'male' => 'male',
        ),
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['first_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('First Name'))
      ->setDescription(t('The first name of the Contact entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['last_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Last Name'))
      ->setDescription(t('The first name of the Contact entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['birth_date'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Birth date'))
      ->setDescription(t('Your birth date'))
      ->setSetting('date_time', 'date')
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Birth date'))
      ->setDescription(t('Your Email'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
