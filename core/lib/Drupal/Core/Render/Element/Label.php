<?php

/**
 * @file
 * Contains \Drupal\Core\Render\Element\Label.
 */

namespace Drupal\Core\Render\Element;

/**
 * Provides a render element for displaying the label for a form element.
 *
 * Labels are generated automatically from element properties during processing
 * of most form elements.
 *
 * @RenderElement("label")
 */
class Label extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return array(
      '#theme' => 'form_element_label',
    );
  }

}
