<?php

namespace Drupal\charts;

class ChartsDataItem {

  private $data;
  private $color;
  private $title;

  public function __construct() {
    $this->setData(NULL);
    $this->setColor(NULL);
    $this->setTitle(NULL);
  }

  /**
   * @param mixed $color
   */
  public function setColor($color) {
    $this->color = $color;
  }

  /**
   * @return mixed
   */
  public function getColor() {
    return $this->color;
  }

  /**
   * @param mixed $data
   */
  public function setData($data) {
    $this->data = $data;
  }

  /**
   * @return mixed
   */
  public function getData() {
    return $this->data;
  }

  /**
   * @param mixed $title
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }
}
