<?php

namespace Drupal\charts;

use Drupal\Core\Plugin\PluginBase;

abstract class ChartBase extends PluginBase implements ChartPluginInterface {

  const CHARTS_SINGLE_AXIS = 'y_only';
  const CHARTS_DUAL_AXIS = 'xy';

  /**
   * @var Chart $chart
   */
  protected $chart;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * @param Chart $chart
   */
  public function setChart(Chart $chart) {
    $this->chart = $chart;
  }

  /**
   * Recursive function to trim out empty options that aren't used.
   */
  protected function charts_trim_array(&$array) {
    foreach ($array as $key => &$value) {
      if (is_array($value)) {
        $this->charts_trim_array($value);
      }
      elseif (is_null($value) || (is_array($value) && count($value) === 0)) {
        unset($array[$key]);
      }
    }
  }

  /**
   * Implements hook_charts_type_info().
   */
  protected function chart_get_type($type) {
    $chart_types['pie'] = array(
      'label' => t('Pie'),
      'axis' => ChartBase::CHARTS_SINGLE_AXIS,
      'axis_inverted' => FALSE,
      'stacking' => FALSE,
    );
    $chart_types['bar'] = array(
      'label' => t('Bar'),
      'axis' => ChartBase::CHARTS_DUAL_AXIS,
      'axis_inverted' => TRUE, // Meaning x/y axis are flipped.
      'stacking' => TRUE,
    );
    $chart_types['column'] = array(
      'label' => t('Column'),
      'axis' => ChartBase::CHARTS_DUAL_AXIS,
      'axis_inverted' => FALSE,
      'stacking' => TRUE,
    );
    $chart_types['line'] = array(
      'label' => t('Line'),
      'axis' => ChartBase::CHARTS_DUAL_AXIS,
      'axis_inverted' => FALSE,
      'stacking' => FALSE,
    );
    $chart_types['area'] = array(
      'label' => t('Area'),
      'axis' => ChartBase::CHARTS_DUAL_AXIS,
      'axis_inverted' => FALSE,
      'stacking' => TRUE,
    );
    $chart_types['scatter'] = array(
      'label' => t('Scatter'),
      'axis' => ChartBase::CHARTS_DUAL_AXIS,
      'axis_inverted' => FALSE,
      'stacking' => FALSE,
    );
    return $chart_types[$type];
  }

}
