<?php

namespace Drupal\charts;

class ChartAxis {

  private $axis_type;
  private $title;
  private $title_color;
  private $title_font_weight;
  private $title_font_style;
  private $title_font_size;
  private $labels;
  private $labels_color;
  private $labels_font_weight;
  private $labels_font_style;
  private $labels_font_size;
  private $labels_rotation;
  private $grid_line_color;
  private $base_line_color;
  private $minor_grid_line_color;
  private $max;
  private $min;
  private $opposite;

  public function __construct() {
    $this->setAxisType('linear');
    $this->setTitle('');
    $this->setTitleColor('#000');
    $this->setTitleFontWeight('normal');
    $this->setTitleFontStyle('normal');
    $this->setTitleFontSize(12);
    $this->setLabels(NULL);
    $this->setLabelsColor('#000');
    $this->setLabelsFontWeight('normal');
    $this->setLabelsFontStyle('normal');
    $this->setLabelsFontSize(NULL);
    $this->setLabelsRotation(NULL);
    $this->setGridLineColor('#ccc');
    $this->setBaseLineColor('#ccc');
    $this->setMinorGridLineColor('#e0e0e0');
    $this->setMax(NULL);
    $this->setMin(NULL);
    $this->setOpposite(FALSE);
  }

  /**
   * @param mixed $axis_type
   */
  public function setAxisType($axis_type) {
    $this->axis_type = $axis_type;
  }

  /**
   * @return mixed
   */
  public function getAxisType() {
    return $this->axis_type;
  }

  /**
   * @param mixed $base_line_color
   */
  public function setBaseLineColor($base_line_color) {
    $this->base_line_color = $base_line_color;
  }

  /**
   * @return mixed
   */
  public function getBaseLineColor() {
    return $this->base_line_color;
  }

  /**
   * @param mixed $grid_line_color
   */
  public function setGridLineColor($grid_line_color) {
    $this->grid_line_color = $grid_line_color;
  }

  /**
   * @return mixed
   */
  public function getGridLineColor() {
    return $this->grid_line_color;
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
   * @param mixed $labels_color
   */
  public function setLabelsColor($labels_color) {
    $this->labels_color = $labels_color;
  }

  /**
   * @return mixed
   */
  public function getLabelsColor() {
    return $this->labels_color;
  }

  /**
   * @param mixed $labels_font_size
   */
  public function setLabelsFontSize($labels_font_size) {
    $this->labels_font_size = $labels_font_size;
  }

  /**
   * @return mixed
   */
  public function getLabelsFontSize() {
    return $this->labels_font_size;
  }

  /**
   * @param mixed $labels_font_style
   */
  public function setLabelsFontStyle($labels_font_style) {
    $this->labels_font_style = $labels_font_style;
  }

  /**
   * @return mixed
   */
  public function getLabelsFontStyle() {
    return $this->labels_font_style;
  }

  /**
   * @param mixed $labels_font_weight
   */
  public function setLabelsFontWeight($labels_font_weight) {
    $this->labels_font_weight = $labels_font_weight;
  }

  /**
   * @return mixed
   */
  public function getLabelsFontWeight() {
    return $this->labels_font_weight;
  }

  /**
   * @param mixed $labels_rotation
   */
  public function setLabelsRotation($labels_rotation) {
    $this->labels_rotation = $labels_rotation;
  }

  /**
   * @return mixed
   */
  public function getLabelsRotation() {
    return $this->labels_rotation;
  }

  /**
   * @param mixed $max
   */
  public function setMax($max) {
    $this->max = $max;
  }

  /**
   * @return mixed
   */
  public function getMax() {
    return $this->max;
  }

  /**
   * @param mixed $min
   */
  public function setMin($min) {
    $this->min = $min;
  }

  /**
   * @return mixed
   */
  public function getMin() {
    return $this->min;
  }

  /**
   * @param mixed $minor_grid_line_color
   */
  public function setMinorGridLineColor($minor_grid_line_color) {
    $this->minor_grid_line_color = $minor_grid_line_color;
  }

  /**
   * @return mixed
   */
  public function getMinorGridLineColor() {
    return $this->minor_grid_line_color;
  }

  /**
   * @param mixed $opposite
   */
  public function setOpposite($opposite) {
    $this->opposite = $opposite;
  }

  /**
   * @return mixed
   */
  public function getOpposite() {
    return $this->opposite;
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
   * @param mixed $title_color
   */
  public function setTitleColor($title_color) {
    $this->title_color = $title_color;
  }

  /**
   * @return mixed
   */
  public function getTitleColor() {
    return $this->title_color;
  }

  /**
   * @param mixed $title_font_size
   */
  public function setTitleFontSize($title_font_size) {
    $this->title_font_size = $title_font_size;
  }

  /**
   * @return mixed
   */
  public function getTitleFontSize() {
    return $this->title_font_size;
  }

  /**
   * @param mixed $title_font_style
   */
  public function setTitleFontStyle($title_font_style) {
    $this->title_font_style = $title_font_style;
  }

  /**
   * @return mixed
   */
  public function getTitleFontStyle() {
    return $this->title_font_style;
  }

  /**
   * @param mixed $title_font_weight
   */
  public function setTitleFontWeight($title_font_weight) {
    $this->title_font_weight = $title_font_weight;
  }

  /**
   * @return mixed
   */
  public function getTitleFontWeight() {
    return $this->title_font_weight;
  }
}
