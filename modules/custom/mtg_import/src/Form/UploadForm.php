<?php

/**
 * @file
 * Contains \Drupal\mtg_import\Form\UploadForm.
 */

namespace Drupal\mtg_import\Form;

use Drupal\Core\Site\Settings;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Upload form.
 */
class UploadForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mtg_import_upload_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['mtg_import_json_file'] = [
      '#title' => t('Select file'),
      '#type' => 'managed_file',
      '#upload_location' => 'public://mtg_json_files',
      '#upload_validators' => array(
        'file_validate_extensions' => array('json')
      ),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('You did it! You uploaded a file!');
  }

}
