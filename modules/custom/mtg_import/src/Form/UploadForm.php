<?php

/**
 * @file
 * Contains \Drupal\mtg_import\Form\UploadForm.
 */

namespace Drupal\mtg_import\Form;

use Drupal\mtg_import;

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
      '#description' => t('File must be a <strong>json</strong> file.'),
      '#required' => TRUE,
    ];

    $form['mtg_import_overwrite_existing'] = [
      '#title' => t('Overwrite existing cards?'),
      '#type' => 'checkbox',
      '#description' => t('If checked, any matching cards will be overwritten, rather than adding a new instance.'),
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
    // Pass the file to the parser.
    $fid = $form_state->getValue('mtg_import_json_file');
    $fid = reset($fid);

    $overwrite = $form_state->getValue('mtg_import_overwrite_existing');

    if (mtg_import_receive_file($fid, $overwrite)) {
      drupal_set_message(t('Successfully imported file.'));
    }
  }

}
