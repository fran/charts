<?php

namespace Drupal\charts\Controller;

use Drupal\charts\Chart;
use Drupal\charts\ChartBase;
use Drupal\charts\ChartsData;
use Drupal\charts\ChartsDataItem;
use Drupal\charts\ChartService;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChartsController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * @var \Drupal\charts\ChartService
   */
  private $chartService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('chart')
    );
  }

  /**
   * @param ChartService $chartService
   */
  public function __construct(ChartService $chartService) {
    $this->chartService = $chartService;
  }

  /**
   * @param null $library
   * @param null $id
   *
   * @return string
   */
  public function exampleAction($library = NULL, $id = NULL) {
    $methods = get_class_methods('\Drupal\charts\Controller\ChartsController');

    /** @var ChartBase[] $plugins */
    $plugins = $this->chartService->getChartPlugins();

    $table = array();
    foreach ($plugins as $plugin) {
      $table['header'][] = array(
        'width' => (1 / count($plugins) * 100) . '%',
        'data' => $plugin['label'],
      );
    }

    $table['rows'] = array();
    foreach ($methods as $method) {
      if (($id && '_charts_examples_' . $id === $method) || (!$id && strpos($method, '_charts_examples_') === 0)) {
        $row = array();
        foreach ($plugins as $plugin) {
          $example = $this->{$method}();

          /** @var Chart $chart */
          $chart = $example['chart'];
          $chart->setEngine($plugin['id']);
          $chart->setHeight(200);
          $notes = '';
          if (isset($example['notes'][$plugin['id']])) {
            $notes = '<p>' . t('Note') . ': ' . $example['notes'][$plugin['id']] . '</p>';
          }
          $row[] = array(
            'data' => drupal_render($this->chartService->getChartPlugin($chart)
                ->render()) . l(t('View'), 'charts/examples/built-in/' . $library . '/' . str_replace('_charts_examples_', '', $method)) . $notes,
            'valign' => 'top',
          );
        }
        $table['rows'][] = $row;
      }
    }

    return theme('table', $table);
  }

  /**
   * @return mixed
   */
  function _charts_examples_pie_simple() {
    $chart = new Chart();
    $chart->setTitle(t('Simple'));
    $chart->setChartType(Chart::PIE);
    $chart->setLegendPosition('right');
    $chart->setDataLabels(TRUE);
    $chart->setTooltips(FALSE);

    $chart_data = new ChartsData();
    $chart_data->setTitle('Gender');
    $chart_data->setLabels(array('Male', 'Female'));
    $chart_data->setData(array(10, 20));

    $chart->addData('pie_data', $chart_data);

    $example['chart'] = $chart;

    return $example;
  }

  /**
   * @return mixed
   */
  function _charts_examples_pie_tooltips() {
    $example = $this->_charts_examples_pie_simple();

    /** @var Chart $chart */
    $chart = $example['chart'];
    $chart->setTitle(t('Tooltip'));
    $chart->setTooltips(TRUE);
    $chart->setDataLabels(FALSE);

    return $example;
  }

  /**
   * TODO: convert to object
   */
  function _charts_examples_pie_alternative_syntax() {
    $chart = array(
      '#type' => 'chart',
      '#title' => t('Pie alternative syntax'),
      '#chart_type' => 'pie',
      '#chart_library' => 'highcharts',
      '#legend_position' => 'right',
      '#data_labels' => TRUE,
      '#tooltips' => FALSE,
    );
    $chart['pie_data'] = array(
      '#type' => 'chart_data',
      '#title' => t('Gender'),
      '#data' => array(array('Male', 10), array('Female', 20)),
    );

    $example['chart'] = $chart;

    return $example;
  }

  /**
   * @return mixed
   */
  function _charts_examples_pie_data_overrides() {
    $example = $this->_charts_examples_pie_simple();

    /** @var Chart $chart */
    $chart = $example['chart'];
    $chart->setTitle(t('Overrides'));
    $chart->setTooltips(TRUE);

    /** @var ChartsData $chart_data */
    $chart_data = $chart->getDataByKey('pie_data');

    $data_item_1 = new ChartsDataItem();
    $data_item_1->setData(15);
    $data_item_1->setColor('red');
    $data_item_1->setTitle(t('Dudes'));
    $chart_data->addDataItem($data_item_1);

    $data_item_2 = new ChartsDataItem();
    $data_item_2->setData(20);
    $data_item_2->setTitle(t('Chicks'));
    $chart_data->addDataItem($data_item_2);

    $example['notes']['google'] = t('Google cannot assign a color to an individual item. See this <a href="https://code.google.com/p/google-visualization-api-issues/issues/detail?id=1267">feature request</a>.');

    return $example;
  }

  /**
   * TODO: convert to object
   */
  function _charts_examples_column_simple() {
    $chart = array(
      '#type' => 'chart',
      '#chart_type' => 'column',
      '#title' => t('Column simple'),
    );
    $chart['male'] = array(
      '#type' => 'chart_data',
      '#title' => t('Male'),
      '#data' => array(10, 20, 30),
      '#suffix' => 'lbs',
    );
    $chart['female'] = array(
      '#type' => 'chart_data',
      '#title' => t('Female'),
      '#data' => array(12, 22, 32),
      '#suffix' => 'lbs',
    );
    $chart['xaxis'] = array(
      '#type' => 'chart_xaxis',
      '#labels' => array('Jan', 'Feb', 'Mar'),
    );

    $example['chart'] = $chart;

    return $example;
  }

  /**
   * TODO: convert to object
   */
  function _charts_examples_bar_simple() {
    $example = _charts_examples_column_simple();
    $example['chart']['#title'] = t('Bar simple');
    $example['chart']['#chart_type'] = 'bar';
    return $example;
  }

  /**
   * TODO: convert to object
   */
  function _charts_examples_scatter() {
    $chart = array(
      '#type' => 'chart',
      '#chart_type' => 'scatter',
      '#title' => t('Scatter'),
    );
    $chart['male'] = array(
      '#type' => 'chart_data',
      '#title' => t('Male'),
      '#data' => array(array(10, 10), array(20, 20), array(30, 30)),
    );
    $chart['female'] = array(
      '#type' => 'chart_data',
      '#title' => t('Female'),
      '#data' => array(array(12, 12), array(20, 24), array(30, 36)),
    );

    $example['chart'] = $chart;

    return $example;
  }

  /**
   * TODO: convert to object
   */
  function _charts_examples_combo() {
    $chart = array(
      '#type' => 'chart',
      '#chart_type' => 'column',
      '#title' => t('Combo'),
      '#legend_position' => 'bottom',
    );
    $chart['male'] = array(
      '#type' => 'chart_data',
      '#title' => t('Male'),
      '#data' => array(10, 20, 30),
      '#suffix' => 'lbs',
    );
    $chart['female'] = array(
      '#type' => 'chart_data',
      '#title' => t('Female'),
      '#data' => array(12, 22, 32),
      '#suffix' => 'lbs',
    );
    $chart['female'][0] = array(
      '#type' => 'chart_data_item',
      '#title' => t('Special title'),
      '#color' => 'red',
      '#data' => 22,
    );

    $secondary_color = '#B617E5';
    $chart['line'] = array(
      '#type' => 'chart_data',
      '#chart_type' => 'line',
      '#data' => array(7, 44, 100),
      '#title' => t('Average'),
      '#target_axis' => 'yaxis2',
      '#color' => $secondary_color,
      //'#marker_radius' => 10,
      '#prefix' => '$',
    );
    $chart['line'][1] = array(
      '#type' => 'chart_data_item',
      //'#color' => 'red',
      //'#radius' => 10,
    );

    $chart['xaxis'] = array(
      '#type' => 'chart_xaxis',
      '#labels' => array('Jan', 'Feb', 'Mar'),
    );

    $chart['yaxis'] = array(
      '#type' => 'chart_yaxis',
      '#axis_type' => 'linear',
    );

    $chart['yaxis2'] = array(
      '#type' => 'chart_yaxis',
      '#axis_type' => 'linear',
      '#opposite' => TRUE,
      '#title' => t('Avg'),
      '#labels_color' => $secondary_color,
      '#title_color' => $secondary_color,
    );

    $example['chart'] = $chart;

    $example['notes']['google'] = t('Google charts cannot provide a legend on the same side as an axis, so legends cannot be displayed on the left or right in a combo chart.') . ' ' . t('Google cannot assign a color to an individual item. See this <a href="https://code.google.com/p/google-visualization-api-issues/issues/detail?id=1267">feature request</a>.');

    return $example;
  }
}
