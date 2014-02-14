<?php

namespace Drupal\charts;

use Drupal\charts\Chart\Chart;
use Drupal\charts\Plugin\ChartBase;
use Drupal\charts\Plugin\Type\ChartsManager;

class ChartService {

  private $chartsManager;

  /**
   * @param ChartsManager $chartsManager
   */
  public function __construct(ChartsManager $chartsManager) {
    $this->chartsManager = $chartsManager;
  }

  /**
   * @param Chart $chart
   * @return ChartBase
   */
  public function getChartPlugin(Chart $chart) {
    /** @var ChartBase $instance */
    $instance = $this->chartsManager->createInstance($chart->getEngine());
    $instance->setChart($chart);

    return $instance;
  }

  /**
   * @return array
   */
  public function getChartPlugins() {
    return $this->chartsManager->getDefinitions();
  }
}
