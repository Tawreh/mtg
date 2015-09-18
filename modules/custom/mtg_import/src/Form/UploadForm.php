<?php

/**
 * @file
 * Contains \Drupal\mtg_import\Form\UploadForm.
 */

namespace Drupal\mtg_import\Form;

use Drupal\mtg_import;

use Drupal\file\Entity\File;
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
        'file_validate_extensions' => array('json'),
      ),
      '#description' => t('File must be a <strong>json</strong> file.'),
      '#required' => TRUE,
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

    if ($fid == 0) {
      return FALSE;
    }

    $file = File::load($fid);

    if (!$file) {
      drupal_set_message('Unable to load file.');
      \Drupal::logger('mtg_import')->error(t('Unable to load the file.'));
      return FALSE;
    }

    $uri = $file->uri->value;
    $file_contents_raw = file_get_contents($uri);
    $file_contents = json_decode($file_contents_raw);

    if (isset($file_contents->cards) && !empty($file_contents->cards)) {
      $operations = [
        ['mtg_import_parse_set_data', [$file_contents]],
      ];

      $chunks = array_chunk($file_contents->cards, 20);
      foreach ($chunks as $chunk) {
        $operations[] = ['mtg_import_parse_card_data', [$chunk]];
      }

      $batch = [
        'title' => t('Importing'),
        'operations' => $operations,
        'finished' => 'mtg_import_completed',
        'progress_message' => t('Completed part @current of @total.'),
      ];

      batch_set($batch);
    }
    else {
      drupal_set_message(t('There are no cards in the file, so no import will take place.'), 'warning');
    }
  }

}
