<?php

namespace Drupal\age_verification\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * TODO: class docs.
 */
class AgeVerificationSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'age_verification_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config('age_verification.settings');
    $allowed_ext = 'gif png jpg jpeg';

    $form['bg_image'] = [
      '#type' => "managed_file",
      '#title' => $this->t("Image"),
      '#description' => $this->t(
        'Modal background image. Allowed extensions: @allowed_ext', [
          '@allowed_ext' => $allowed_ext,
        ]
      ),
      '#upload_location' => 'public://age_verification/',
      '#required' => TRUE,
      '#default_value' => $config->get('bg_image'),
      '#upload_validators' => [
        'file_validate_extensions' => [$allowed_ext],
        'file_validate_size' => [2000000],
      ],
    ];
    $form['btn_text'] = [
      '#type' => "textfield",
      '#title' => $this->t("Button Text"),
      '#required' => TRUE,
      '#default_value' => $config->get('btn_text'),
    ];
    $form['text'] = [
      '#type' => "textarea",
      '#title' => $this->t("Text"),
      '#description' => $this->t("Text shown in the modal"),
      '#required' => TRUE,
      '#default_value' => $config->get('text'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('age_verification.settings');

    $bg_image = $form_state->getValue('bg_image');
    $fid = reset($bg_image);
    $file = File::load($fid);
    $file->setPermanent();
    $file->save();

    $config->set('bg_image', $bg_image);
    $config->set('btn_text', $form_state->getValue('btn_text'));
    $config->set('text', $form_state->getValue('text'));
    $config->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['age_verification.settings'];
  }

}
