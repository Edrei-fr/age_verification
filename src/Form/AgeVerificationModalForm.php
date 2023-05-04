<?php

namespace Drupal\age_verification\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AgeVerificationModalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'age_verification_modal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('age_verification.settings');

    $form['markup'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $config->get('text') . '</p>',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $config->get('btn_text'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $av_cookie = new Cookie('age_verified', TRUE, 0, NULL, NULL, NULL, FALSE);
    $front = Url::fromRoute('<front>')->toString();
    $response = new RedirectResponse($front);
    $response->headers->setCookie($av_cookie);
    $response->send();
  }

}
