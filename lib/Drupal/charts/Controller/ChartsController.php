<?php

namespace Drupal\charts\Controller;

use Drupal\charts\Chart\Chart;
use Drupal\charts\Chart\ChartAxis;
use Drupal\charts\Plugin\ChartBase;
use Drupal\charts\Chart\ChartsData;
use Drupal\charts\Chart\ChartsDataItem;
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
            $notes = '<p>' . $this->t('Note') . ': ' . $example['notes'][$plugin['id']] . '</p>';
          }

          $render = $this->chartService->getChartPlugin($chart)->render();
          $row[] = array(
            'data' => drupal_render($render) . l($this->t('View'), 'charts/examples/built-in/' . $library . '/' . str_replace('_charts_examples_', '', $method)) . $notes,
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
    $chart->setTitle($this->t('Simple'));
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
    $chart->setTitle($this->t('Tooltip'));
    $chart->setTooltips(TRUE);
    $chart->setDataLabels(FALSE);

    return $example;
  }

  /**
   *
   */
  function _charts_examples_pie_alternative_syntax() {
    $chart = new Chart();
    $chart->setTitle($this->t('Alternative'));
    $chart->setChartType(Chart::PIE);
    $chart->setLegendPosition('right');
    $chart->setDataLabels(TRUE);
    $chart->setTooltips(FALSE);

    $chart_data = new ChartsData();
    $chart_data->setTitle($this->t('Gender'));
    $chart_data->setData(array(array('Male', 10), array('Female', 20)));
    $chart->addData('pie_data', $chart_data);

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
    $chart->setTitle($this->t('Overrides'));
    $chart->setTooltips(TRUE);

    /** @var ChartsData $chart_data */
    $chart_data = $chart->getDataByKey('pie_data');

    $data_item_1 = new ChartsDataItem();
    $data_item_1->setData(15);
    $data_item_1->setColor('red');
    $data_item_1->setTitle($this->t('Dudes'));
    $chart_data->addDataItem($data_item_1);

    $data_item_2 = new ChartsDataItem();
    $data_item_2->setData(20);
    $data_item_2->setTitle($this->t('Chicks'));
    $chart_data->addDataItem($data_item_2);

    $example['notes']['GoogleCharts'] = $this->t('Google cannot assign a color to an individual item. See this <a href="https://code.google.com/p/google-visualization-api-issues/issues/detail?id=1267">feature request</a>.');

    return $example;
  }

  /**
   *
   */
  function _charts_examples_column_simple() {
    $chart = new Chart();
    $chart->setTitle($this->t('Column'));
    $chart->setChartType(Chart::COLUMN);

    $chart_data_male = new ChartsData();
    $chart_data_male->setTitle($this->t('Male'));
    $chart_data_male->setData(array(10, 20, 30));
    $chart_data_male->setSuffix('lbs');
    $chart->addData('male', $chart_data_male);

    $chart_data_female = new ChartsData();
    $chart_data_female->setTitle($this->t('Female'));
    $chart_data_female->setData(array(12, 22, 32));
    $chart_data_female->setSuffix('lbs');
    $chart->addData('female', $chart_data_female);

    $chart_xaxis = new ChartAxis();
    $chart_xaxis->setType('xaxis');
    $chart_xaxis->setLabels(array('Jan', 'Feb', 'Mar'));
    $chart->addXaxis('xaxis', $chart_xaxis);

    $example['chart'] = $chart;

    return $example;
  }

  /**
   *
   */
  function _charts_examples_bar_simple() {
    $example = $this->_charts_examples_column_simple();

    /** @var Chart $chart */
    $chart = $example['chart'];

    $chart->setTitle($this->t('Bar'));
    $chart->setChartType(Chart::BAR);

    return $example;
  }

  /**
   *
   */
  function _charts_examples_scatter() {
    $chart = new Chart();
    $chart->setTitle($this->t('Scatter'));
    $chart->setChartType(Chart::SCATTER);

    $chart_data_male = new ChartsData();
    $chart_data_male->setTitle($this->t('Male'));
    $chart_data_male->setData(array(array(10, 10), array(20, 20), array(30, 30)));
    $chart->addData('male', $chart_data_male);

    $chart_data_female = new ChartsData();
    $chart_data_female->setTitle($this->t('Female'));
    $chart_data_female->setData(array(array(12, 12), array(20, 24), array(30, 36)));
    $chart_data_female->setSuffix('lbs');
    $chart->addData('female', $chart_data_female);

    $example['chart'] = $chart;

    return $example;
  }

  /**
   *
   */
  function _charts_examples_combo() {
    $chart = new Chart();
    $chart->setTitle($this->t('Combo'));
    $chart->setChartType(Chart::COLUMN);
    $chart->setLegendPosition('bottom');

    $chart_data_male = new ChartsData();
    $chart_data_male->setTitle($this->t('Male'));
    $chart_data_male->setData(array(10, 20, 30));
    $chart->addData('male', $chart_data_male);

    $chart_data_female = new ChartsData();
    $chart_data_female->setTitle($this->t('Female'));
    $chart_data_female->setData(array(12, 22, 32));
    $chart_data_female->setSuffix('lbs');
    $chart->addData('female', $chart_data_female);

    $chart_data_item = new ChartsDataItem();
    $chart_data_item->setTitle($this->t('Special'));
    $chart_data_item->setColor('red');
    $chart_data_item->setData(22);
    $chart_data_female->addDataItem($chart_data_item);

    $secondary_color = '#B617E5';

    $chart_data_line = new ChartsData();
    $chart_data_line->setChartType(Chart::LINE);
    $chart_data_line->setData(array(7, 44, 100));
    $chart_data_line->setTitle($this->t('Average'));
    $chart_data_line->setTargetAxis('yaxis2');
    $chart_data_line->setColor($secondary_color);
    $chart_data_line->setPrefix('$');
    $chart->addData('line', $chart_data_line);

    $chart_data_item2 = new ChartsDataItem();
    $chart_data_line->addDataItem($chart_data_item2);

    $chart_xaxis = new ChartAxis();
    $chart_xaxis->setType('xaxis');
    $chart_xaxis->setLabels(array('Jan', 'Feb', 'Mar'));
    $chart->addXaxis('xaxis', $chart_xaxis);

    $chart_yaxis = new ChartAxis();
    $chart_xaxis->setType('yaxis');
    $chart_yaxis->setAxisType('linear');
    $chart->addYaxis('yaxis', $chart_yaxis);

    $chart_yaxis2 = new ChartAxis();
    $chart_xaxis->setType('yaxis');
    $chart_yaxis2->setAxisType('linear');
    $chart_yaxis2->setOpposite(TRUE);
    $chart_yaxis2->setTitle($this->t('Avg'));
    $chart_yaxis2->setLabelsColor($secondary_color);
    $chart_yaxis2->setTitleColor($secondary_color);
    $chart->addYaxis('yaxis2', $chart_yaxis2);

    $example['chart'] = $chart;

    $example['notes']['GoogleCharts'] = $this->t('Google charts cannot provide a legend on the same side as an axis, so legends cannot be displayed on the left or right in a combo chart.') . ' ' . $this->t('Google cannot assign a color to an individual item. See this <a href="https://code.google.com/p/google-visualization-api-issues/issues/detail?id=1267">feature request</a>.');

    return $example;
  }
}
