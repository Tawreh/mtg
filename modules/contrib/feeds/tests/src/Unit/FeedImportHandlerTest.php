<?php

/**
 * @file
 * Contains \Drupal\Tests\feeds\Unit\FeedImportHandlerTest.
 */

namespace Drupal\Tests\feeds\Unit;

use Drupal\feeds\Event\FeedsEvents;
use Drupal\feeds\Event\FetchEvent;
use Drupal\feeds\Event\ParseEvent;
use Drupal\feeds\Event\ProcessEvent;
use Drupal\feeds\Exception\EmptyFeedException;
use Drupal\feeds\FeedImportHandler;
use Drupal\feeds\StateInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @coversDefaultClass \Drupal\feeds\FeedImportHandler
 * @group feeds
 */
class FeedImportHandlerTest extends FeedsUnitTestCase {

  protected $dispatcher;
  protected $feed;

  public function setUp() {
    parent::setUp();

    $this->dispatcher = new EventDispatcher();
    $this->handler = new FeedImportHandler($this->dispatcher);
    $this->handler->setStringTranslation($this->getStringTranslationStub());

    $this->feed = $this->getMock('Drupal\feeds\FeedInterface');
    $this->feed->expects($this->any())
      ->method('id')
      ->will($this->returnValue(10));
    $this->feed->expects($this->any())
      ->method('bundle')
      ->will($this->returnValue('test_feed'));
  }

  public function testStartBatchImport() {
    $this->feed->expects($this->once())
      ->method('lock')
      ->will($this->returnValue($this->feed));

    $this->handler->startBatchImport($this->feed);
  }

  public function testBatchFetch() {
    $this->handler->batchFetch($this->feed);
  }

}
