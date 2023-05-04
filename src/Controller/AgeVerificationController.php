<?php

namespace Drupal\age_verification\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;

class AgeVerificationController extends ControllerBase {

  public function openModal() {
    $response = new AjaxResponse();
    $modal_form = $this->formBuilder()->getForm('Drupal\age_verification\Form\AgeVerificationModalForm');
    $options = [
      'width' => '100%',
      'classes' => [
        'ui-dialog' => 'av-img',
        'ui-dialog-titlebar' => 'no-titlebar',
      ],
    ];
    $response->addCommand(new OpenModalDialogCommand('', $modal_form, $options));
    return $response;
  }

}
