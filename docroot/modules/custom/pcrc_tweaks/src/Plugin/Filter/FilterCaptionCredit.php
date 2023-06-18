<?php

namespace Drupal\pcrc_tweaks\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Unicode;
use Drupal\Component\Utility\Xss;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\Render\FilteredMarkup;

/**
 * Provides a filter to add captions and credit elements.
 *
 * When used in combination with the filter_align filter, this must run last.
 *
 * @Filter(
 *   id = "filter_caption_credit",
 *   title = @Translation("Caption and credit images"),
 *   description = @Translation("Uses a <code>data-caption</code> and <code>data-credit</code> attribute on <code>&lt;img&gt;</code> tags to caption and credit images."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class FilterCaptionCredit extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);

    if (stristr($text, 'data-caption') !== FALSE || stristr($text, 'data-credit') !== FALSE) {
      $dom = Html::load($text);
      $xpath = new \DOMXPath($dom);
      foreach ($xpath->query('//*[@data-caption] | //*[@data-credit]') as $node) {
         // Read the data-caption attribute's value, then delete it.
        $caption = Html::escape($node->getAttribute('data-caption'));
        $node->removeAttribute('data-caption');
        // Read the data-credit attribute's value, then delete it.
        $credit = Html::escape($node->getAttribute('data-credit'));
        $node->removeAttribute('data-credit');

        // Sanitize caption: decode HTML encoding, limit allowed HTML tags; only
        // allow inline tags that are allowed by default, plus <br>.
        $caption = Html::decodeEntities($caption);
        $caption = FilteredMarkup::create(Xss::filter($caption, ['a', 'em', 'strong', 'cite', 'code', 'br']));
        // Sanitize credit: decode HTML encoding, limit allowed HTML tags; only
        // allow inline tags that are allowed by default, plus <br>.
        $credit = Html::decodeEntities($credit);
        $credit = FilteredMarkup::create(Xss::filter($credit, ['a', 'em', 'strong', 'cite', 'code', 'br']));

        // The caption or credit must be non-empty.
        if (mb_strlen($caption) === 0 && mb_strlen($credit) === 0) {
          continue;
        }

        // Given the updated node and caption or credit: re-render it with caption and credit, but
        // bubble up the value of the class attribute of the element,
        // this allows it to collaborate with e.g. the filter_align filter.
        $tag = $node->tagName;
        $classes = $node->getAttribute('class');
        $node->removeAttribute('class');
        $node = ($node->parentNode->tagName === 'a') ? $node->parentNode : $node;
        $filter_caption_credit = [
          '#theme' => 'filter_caption_credit',
          // We pass the unsanitized string because this is a text format
          // filter, and after filtering, we always assume the output is safe.
          // @see \Drupal\filter\Element\ProcessedText::preRenderText()
          '#node' => FilteredMarkup::create($node->C14N()),
          '#tag' => $tag,
          '#caption' => $caption,  
          '#credit' => $credit,
          '#classes' => $classes,
        ];
        $altered_html = \Drupal::service('renderer')->render($filter_caption_credit);

        // Load the altered HTML into a new DOMDocument and retrieve the element.
        $updated_nodes = Html::load($altered_html)->getElementsByTagName('body')
          ->item(0)
          ->childNodes;

        foreach ($updated_nodes as $updated_node) {
          // Import the updated node from the new DOMDocument into the original
          // one, importing also the child nodes of the updated node.
          $updated_node = $dom->importNode($updated_node, TRUE);
          $node->parentNode->insertBefore($updated_node, $node);
        }
        // Finally, remove the original data-credit node.
        $node->parentNode->removeChild($node);
      }

      $result->setProcessedText(Html::serialize($dom))
        ->addAttachments([
          'library' => [
            'npc_tweaks/caption',
          ],
        ]);
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    if ($long) {
      return $this->t('
        <p>You can caption and credit images, videos, blockquotes, and so on. Examples:</p>
        <ul>
            <li><code>&lt;img src="" data-credit="This is a credit" /&gt;</code></li>
            <li><code>&lt;video src="" data-caption="The Drupal Dance" /&gt;</code></li>
            <li><code>&lt;blockquote data-credit="Dries Buytaert"&gt;Drupal is awesome!&lt;/blockquote&gt;</code></li>
            <li><code>&lt;code data-caption="Hello world in JavaScript."&gt;alert("Hello world!");&lt;/code&gt;</code></li>
        </ul>');
    }
    else {
      return $this->t('You can caption and credit images (<code>data-caption="Text"</code>), but also videos, blockquotes, and so on.');
    }
  }

}
