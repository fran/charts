<?php

namespace Drupal\charts;

class Chart {

  const PIE = 'pie';
  const AREA = 'area';
  const BAR = 'bar';
  const COLUMN = 'column';
  const LINE = 'line';
  const SCATTER = 'scatter';

  private $engine;
  private $chart_type;
  private $chart_id;
  private $title;
  private $title_color;
  private $title_font_weight;
  private $title_font_style;
  private $title_font_size;
  private $title_position;
  private $colors;
  private $font;
  private $font_size;
  private $background;
  private $stacking;
  private $pre_render;
  private $tooltips;
  private $tooltips_use_html;
  private $data_labels;
  private $legend;
  private $legend_title;
  private $legend_title_font_weight;
  private $legend_title_font_style;
  private $legend_title_font_size;
  private $legend_position;
  private $legend_font_weight;
  private $legend_font_style;
  private $legend_font_size;
  private $width;
  private $height;
  private $attributes;
  private $chart_library;
  private $raw_options;

  private $xaxis;
  private $yaxis;
  private $data;

  public function __construct() {
    $this->setEngine(NULL);
    $this->setChartType(NULL);
    $this->setChartId(NULL);
    $this->setTitle(NULL);
    $this->setTitleColor('#000');

    $this->setTitleFontWeight('normal');
    $this->setTitleFontStyle('normal');
    $this->setTitleFontSize(14);
    $this->setTitlePosition('out');
    $this->setColors($this->charts_default_colors());
    $this->setFont('Arial');
    $this->setFontSize(12);
    $this->setBackground('transparent');
    $this->setStacking(NULL);
    $this->setPreRender(array('charts_pre_render_element'));
    $this->setTooltips(TRUE);
    $this->setTooltipsUseHtml(FALSE);
    $this->setDataLabels(FALSE);
    $this->setLegend(TRUE);
    $this->setLegendTitle(NULL);
    $this->setLegendTitleFontWeight('bold');
    $this->setLegendTitleFontStyle('normal');
    $this->setLegendTitleFontSize(NULL);
    $this->setLegendPosition('right');
    $this->setLegendFontWeight('normal');
    $this->setLegendFontStyle('normal');
    $this->setLegendFontSize(NULL);
    $this->setWidth(NULL);
    $this->setHeight(NULL);

    $this->setAttributes(array());
    $this->setChartLibrary(NULL);
    $this->setRawOptions(array());

    $this->setXaxis(array());
    $this->setYaxis(array());
    $this->setData(array());
  }

  /**
   * @param mixed $engine
   */
  public function setEngine($engine) {
    $this->engine = $engine;
  }

  /**
   * @return mixed
   */
  public function getEngine() {
    return $this->engine;
  }

  /**
   * @return array
   */
  private function charts_default_colors() {
    return array(
      '#2f7ed8',
      '#0d233a',
      '#8bbc21',
      '#910000',
      '#1aadce',
      '#492970',
      '#f28f43',
      '#77a1e5',
      '#c42525',
      '#a6c96a',
    );
  }

  /**
   * @param mixed $attributes
   */
  public function setAttributes($attributes) {
    $this->attributes = $attributes;
  }

  /**
   * @return mixed
   */
  public function getAttributes() {
    return $this->attributes;
  }

  /**
   * @param mixed $background
   */
  public function setBackground($background) {
    $this->background = $background;
  }

  /**
   * @return mixed
   */
  public function getBackground() {
    return $this->background;
  }

  /**
   * @param mixed $chart_id
   */
  public function setChartId($chart_id) {
    $this->chart_id = $chart_id;
  }

  /**
   * @return mixed
   */
  public function getChartId() {
    return $this->chart_id;
  }

  /**
   * @param mixed $chart_library
   */
  public function setChartLibrary($chart_library) {
    $this->chart_library = $chart_library;
  }

  /**
   * @return mixed
   */
  public function getChartLibrary() {
    return $this->chart_library;
  }

  /**
   * @param mixed $colors
   */
  public function setColors($colors) {
    $this->colors = $colors;
  }

  /**
   * @return mixed
   */
  public function getColors() {
    return $this->colors;
  }

  /**
   * @param mixed $data_labels
   */
  public function setDataLabels($data_labels) {
    $this->data_labels = $data_labels;
  }

  /**
   * @return mixed
   */
  public function getDataLabels() {
    return $this->data_labels;
  }

  /**
   * @param mixed $font
   */
  public function setFont($font) {
    $this->font = $font;
  }

  /**
   * @return mixed
   */
  public function getFont() {
    return $this->font;
  }

  /**
   * @param mixed $font_size
   */
  public function setFontSize($font_size) {
    $this->font_size = $font_size;
  }

  /**
   * @return mixed
   */
  public function getFontSize() {
    return $this->font_size;
  }

  /**
   * @param mixed $height
   */
  public function setHeight($height) {
    $this->height = $height;
  }

  /**
   * @return mixed
   */
  public function getHeight() {
    return $this->height;
  }

  /**
   * @param mixed $legend
   */
  public function setLegend($legend) {
    $this->legend = $legend;
  }

  /**
   * @return mixed
   */
  public function getLegend() {
    return $this->legend;
  }

  /**
   * @param mixed $legend_font_size
   */
  public function setLegendFontSize($legend_font_size) {
    $this->legend_font_size = $legend_font_size;
  }

  /**
   * @return mixed
   */
  public function getLegendFontSize() {
    return $this->legend_font_size;
  }

  /**
   * @param mixed $legend_font_style
   */
  public function setLegendFontStyle($legend_font_style) {
    $this->legend_font_style = $legend_font_style;
  }

  /**
   * @return mixed
   */
  public function getLegendFontStyle() {
    return $this->legend_font_style;
  }

  /**
   * @param mixed $legend_font_weight
   */
  public function setLegendFontWeight($legend_font_weight) {
    $this->legend_font_weight = $legend_font_weight;
  }

  /**
   * @return mixed
   */
  public function getLegendFontWeight() {
    return $this->legend_font_weight;
  }

  /**
   * @param mixed $legend_position
   */
  public function setLegendPosition($legend_position) {
    $this->legend_position = $legend_position;
  }

  /**
   * @return mixed
   */
  public function getLegendPosition() {
    return $this->legend_position;
  }

  /**
   * @param mixed $legend_title
   */
  public function setLegendTitle($legend_title) {
    $this->legend_title = $legend_title;
  }

  /**
   * @return mixed
   */
  public function getLegendTitle() {
    return $this->legend_title;
  }

  /**
   * @param mixed $legend_title_font_size
   */
  public function setLegendTitleFontSize($legend_title_font_size) {
    $this->legend_title_font_size = $legend_title_font_size;
  }

  /**
   * @return mixed
   */
  public function getLegendTitleFontSize() {
    return $this->legend_title_font_size;
  }

  /**
   * @param mixed $legend_title_font_style
   */
  public function setLegendTitleFontStyle($legend_title_font_style) {
    $this->legend_title_font_style = $legend_title_font_style;
  }

  /**
   * @return mixed
   */
  public function getLegendTitleFontStyle() {
    return $this->legend_title_font_style;
  }

  /**
   * @param mixed $legend_title_font_weight
   */
  public function setLegendTitleFontWeight($legend_title_font_weight) {
    $this->legend_title_font_weight = $legend_title_font_weight;
  }

  /**
   * @return mixed
   */
  public function getLegendTitleFontWeight() {
    return $this->legend_title_font_weight;
  }

  /**
   * @param mixed $pre_render
   */
  public function setPreRender($pre_render) {
    $this->pre_render = $pre_render;
  }

  /**
   * @return mixed
   */
  public function getPreRender() {
    return $this->pre_render;
  }

  /**
   * @param mixed $raw_options
   */
  public function setRawOptions($raw_options) {
    $this->raw_options = $raw_options;
  }

  /**
   * @return mixed
   */
  public function getRawOptions() {
    return $this->raw_options;
  }

  /**
   * @param mixed $stacking
   */
  public function setStacking($stacking) {
    $this->stacking = $stacking;
  }

  /**
   * @return mixed
   */
  public function getStacking() {
    return $this->stacking;
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

  /**
   * @param mixed $title_position
   */
  public function setTitlePosition($title_position) {
    $this->title_position = $title_position;
  }

  /**
   * @return mixed
   */
  public function getTitlePosition() {
    return $this->title_position;
  }

  /**
   * @param mixed $tooltips
   */
  public function setTooltips($tooltips) {
    $this->tooltips = $tooltips;
  }

  /**
   * @return mixed
   */
  public function getTooltips() {
    return $this->tooltips;
  }

  /**
   * @param mixed $tooltips_use_html
   */
  public function setTooltipsUseHtml($tooltips_use_html) {
    $this->tooltips_use_html = $tooltips_use_html;
  }

  /**
   * @return mixed
   */
  public function getTooltipsUseHtml() {
    return $this->tooltips_use_html;
  }

  /**
   * @param mixed $width
   */
  public function setWidth($width) {
    $this->width = $width;
  }

  /**
   * @return mixed
   */
  public function getWidth() {
    return $this->width;
  }

  /**
   * @param $key
   * @param ChartsData $data
   */
  public function addData($key, ChartsData $data) {
    $this->data[$key] = $data;
  }

  /**
   * @param ChartsData[] $data
   */
  public function setData($data) {
    $this->data = $data;
  }

  /**
   * @return ChartsData[]
   */
  public function getData() {
    return array_keys($this->data);
  }

  /**
   * @param $key
   *
   * @return ChartsData
   */
  public function getDataByKey($key) {
    return $this->data[$key];
  }

  /**
   * @param $key
   * @param ChartAxis $xaxis
   */
  public function addXaxis($key, ChartAxis $xaxis) {
    $this->xaxis[$key] = $xaxis;
  }

  /**
   * @param array $xaxis
   */
  public function setXaxis($xaxis) {
    $this->xaxis = $xaxis;
  }

  /**
   * @return mixed
   */
  public function getXaxis() {
    return $this->xaxis;
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function getXaxisByKey($key) {
    return $this->xaxis[$key];
  }

  /**
   * @param $key
   * @param ChartAxis $yaxis
   */
  public function addYaxis($key, ChartAxis $yaxis) {
    $this->yaxis[$key] = $yaxis;
  }

  /**
   * @param mixed $yaxis
   */
  public function setYaxis($yaxis) {
    $this->yaxis = $yaxis;
  }

  /**
   * @return mixed
   */
  public function getYaxis() {
    return $this->yaxis;
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function getYaxisByKey($key) {
    return $this->yaxis[$key];
  }

  /**
   * @param mixed $chart_type
   */
  public function setChartType($chart_type) {
    $this->chart_type = $chart_type;
    //$this->getData()->setChartType($this->getChartType());
  }

  /**
   * @return mixed
   */
  public function getChartType() {
    return $this->chart_type;
  }

}
