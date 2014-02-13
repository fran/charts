<?php

namespace Drupal\charts;

class ChartsData {

  private $title;
  private $labels;
  private $data;
  private $color;
  private $show_in_legend;
  private $show_labels;
  private $chart_type;
  private $line_width;
  private $marker_radius;
  private $target_axis;
  private $decimal_count;
  private $date_format;
  private $prefix;
  private $suffix;
  private $data_item;

  public function __construct() {
    $this->setTitle('');
    $this->setLabels(NULL);
    $this->setData(NULL);
    $this->setColor(NULL);
    $this->setShowInLegend(TRUE);
    $this->setShowLabels(FALSE);
    $this->setChartType(NULL);
    $this->setLineWidth(1);
    $this->setMarkerRadius(3);
    $this->setTargetAxis(NULL);
    $this->setDecimalCount(NULL);
    $this->setDateFormat(NULL);
    $this->setPrefix(NULL);
    $this->setSuffix(NULL);

    $this->setDataItem(array());
  }

  /**
   * @param mixed $chart_type
   */
  public function setChartType($chart_type) {
    $this->chart_type = $chart_type;
  }

  /**
   * @return mixed
   */
  public function getChartType() {
    return $this->chart_type;
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
   * @param mixed $date_format
   */
  public function setDateFormat($date_format) {
    $this->date_format = $date_format;
  }

  /**
   * @return mixed
   */
  public function getDateFormat() {
    return $this->date_format;
  }

  /**
   * @param mixed $decimal_count
   */
  public function setDecimalCount($decimal_count) {
    $this->decimal_count = $decimal_count;
  }

  /**
   * @return mixed
   */
  public function getDecimalCount() {
    return $this->decimal_count;
  }

  /**
   * @param mixed $labels
   */
  public function setLabels($labels) {
    $this->labels = $labels;
  }

  /**
   * @return mixed
   */
  public function getLabels() {
    return $this->labels;
  }

  /**
   * @param mixed $line_width
   */
  public function setLineWidth($line_width) {
    $this->line_width = $line_width;
  }

  /**
   * @return mixed
   */
  public function getLineWidth() {
    return $this->line_width;
  }

  /**
   * @param mixed $marker_radius
   */
  public function setMarkerRadius($marker_radius) {
    $this->marker_radius = $marker_radius;
  }

  /**
   * @return mixed
   */
  public function getMarkerRadius() {
    return $this->marker_radius;
  }

  /**
   * @param mixed $prefix
   */
  public function setPrefix($prefix) {
    $this->prefix = $prefix;
  }

  /**
   * @return mixed
   */
  public function getPrefix() {
    return $this->prefix;
  }

  /**
   * @param mixed $show_in_legend
   */
  public function setShowInLegend($show_in_legend) {
    $this->show_in_legend = $show_in_legend;
  }

  /**
   * @return mixed
   */
  public function getShowInLegend() {
    return $this->show_in_legend;
  }

  /**
   * @param mixed $show_labels
   */
  public function setShowLabels($show_labels) {
    $this->show_labels = $show_labels;
  }

  /**
   * @return mixed
   */
  public function getShowLabels() {
    return $this->show_labels;
  }

  /**
   * @param mixed $suffix
   */
  public function setSuffix($suffix) {
    $this->suffix = $suffix;
  }

  /**
   * @return mixed
   */
  public function getSuffix() {
    return $this->suffix;
  }

  /**
   * @param mixed $target_axis
   */
  public function setTargetAxis($target_axis) {
    $this->target_axis = $target_axis;
  }

  /**
   * @return mixed
   */
  public function getTargetAxis() {
    return $this->target_axis;
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

  /**
   * @param $data_item
   */
  public function addDataItem(ChartsDataItem $data_item) {
    $this->data_item[] = $data_item;
  }

  /**
   * @param ChartsDataItem[] $data_item
   */
  public function setDataItem($data_item) {
    $this->data_item = $data_item;
  }

  /**
   * @return mixed
   */
  public function getDataItem() {
    return $this->data_item;
  }

  /**
   * @param $key
   *
   * @return ChartsDataItem[] $key
   */
  public function getDataItemByKey($key) {
    return $this->data_item[$key];
  }
}
