<?php

namespace Drupal\charts_google\Plugin\ChartsPlugin;

use Drupal\charts\Chart\ChartAxis;
use Drupal\charts\Plugin\ChartBase;
use Drupal\charts\Chart\ChartsData;

/**
 * GoogleCharts
 *
 * @Plugin(
 *   id = "GoogleCharts",
 *   label = @Translation("Google charts plugin")
 * )
 */
class GoogleCharts extends ChartBase {

  /**
   * @return array
   */
  public function render() {
    $options = $this->charts_google_populate_chart_options();
    $data = $this->charts_google_populate_chart_data();
    $axes = $this->charts_google_populate_chart_axes();
    $visualization = $this->charts_google_visualization_type($this->chart->getChartType());

    // Trim out empty options.
    $this->charts_trim_array($options);

    $chart = array(
      'data' => $data['data'],
      'options' => array_merge($options, $data['options']),
      'visualization' => $visualization,
    );

    if ($axes) {
      array_merge($chart, $axes);
    }

    if (isset($data['_data'])) {
      $chart['_data'] = $data['_data'];
    }

    if (!$this->chart->getChartId()) {
      $this->chart->setChartId(drupal_html_id('google-chart-render'));
    }

    return array(
      '#theme' => 'chart',
      '#chart' => $chart,
      '#attached' => array(
        'library' => array(
          array('charts_google', 'charts_google')
        ),
      ),
    );
  }

  /**
   * Utility to convert a Drupal renderable type to a Google visualization type.
   */
  private
  function charts_google_visualization_type($renderable_type) {
    $types = array(
      'area' => 'AreaChart',
      'bar' => 'BarChart',
      'column' => 'ColumnChart',
      'line' => 'LineChart',
      'pie' => 'PieChart',
      'scatter' => 'ScatterChart',
    );
    //drupal_alter('charts_google_visualization_types', $types);
    return isset($types[$renderable_type]) ? $types[$renderable_type] : FALSE;
  }

  /**
   * Utility to populate main chart options.
   */
  private function charts_google_populate_chart_options() {
    $options = array();

    $options['title'] = $this->chart->getTitle() ? $this->chart->getTitle() : NULL;
    $options['titleTextStyle']['color'] = $this->chart->getTitleColor();
    $options['titleTextStyle']['bold'] = $this->chart->getTitleFontWeight() === 'bold' ? TRUE : FALSE;
    $options['titleTextStyle']['italic'] = $this->chart->getTitleFontStyle() === 'italic' ? TRUE : FALSE;
    $options['titleTextStyle']['fontSize'] = $this->chart->getTitleFontSize();
    $options['titlePosition'] = $this->chart->getTitlePosition();
    $options['colors'] = $this->chart->getColors();
    $options['fontName'] = $this->chart->getFont();
    $options['fontSize'] = $this->chart->getFontSize();
    $options['backgroundColor']['fill'] = $this->chart->getBackground();
    $options['isStacked'] = $this->chart->getStacking() ? TRUE : FALSE;
    $options['tooltip']['trigger'] = $this->chart->getTooltips() ? 'focus' : 'none';
    $options['tooltip']['isHtml'] = $this->chart->getTooltipsUseHtml() ? TRUE : FALSE;
    $options['pieSliceText'] = $this->chart->getDataLabels() ? NULL : 'none';
    $options['legend']['position'] = $this->chart->getLegendPosition() ? $this->chart->getLegendPosition() : 'none';
    $options['legend']['alignment'] = 'center';

    // TODO: Legend title (and thus these properties) not supported by Google.
    $options['legend']['title'] = $this->chart->getLegendTitle();
    $options['legend']['titleTextStyle']['bold'] = $this->chart->getLegendFontWeight() === 'bold' ? TRUE : FALSE;
    $options['legend']['titleTextStyle']['italic'] = $this->chart->getLegendFontStyle() === 'italic' ? TRUE : FALSE;
    $options['legend']['titleTextStyle']['fontSize'] = $this->chart->getLegendFontSize();

    $options['legend']['textStyle']['bold'] = $this->chart->getLegendFontWeight() === 'bold' ? TRUE : FALSE;
    $options['legend']['textStyle']['italic'] = $this->chart->getLegendFontStyle() === 'italic' ? TRUE : FALSE;
    $options['legend']['textStyle']['fontSize'] = $this->chart->getLegendFontSize();
    $options['width'] = $this->chart->getwidth() ? $this->chart->getwidth() : NULL;
    $options['height'] = $this->chart->getheight() ? $this->chart->getheight() : NULL;

    $options['animation']['duration'] = 10000;
    $options['animation']['easing'] = 'out';

    return $options;
  }

  /**
   * Utility to populate chart axes.
   */
  private function charts_google_populate_chart_axes() {
    $chart_definition = NULL;

    $xaxis = $this->chart->getXaxis();
    $yaxis = $this->chart->getYaxis();

    $axis = array_merge($xaxis, $yaxis);

    foreach ($axis as $key => $value) {
      /** @var ChartAxis $value */

      // Populate the chart data.
      $axis = array();
      $axis['title'] = $value->getTitle() ? $value->getTitle() : '';
      $axis['titleTextStyle']['color'] = $value->getTitleColor();
      $axis['titleTextStyle']['bold'] = $value->getTitleFontWeight() === 'bold' ? TRUE : FALSE;
      $axis['titleTextStyle']['italic'] = $value->getTitleFontStyle() === 'italic' ? TRUE : FALSE;
      $axis['titleTextStyle']['fontSize'] = $value->getTitleFontSize();
      // In Google, the row column of data is used as labels.
      if ($value->getLabels() && $value->getType() === 'xaxis') {
        foreach ($value->getLabels() as $label_key => $label) {
          $chart_definition['data'][$label_key + 1][0] = $label;
        }
      }
      $axis['textStyle']['color'] = $value->getLabelsColor();
      $axis['textStyle']['bold'] = $value->getLabelsFontWeight() === 'bold' ? TRUE : FALSE;
      $axis['textStyle']['italic'] = $value->getLabelsFontStyle() === 'italic' ? TRUE : FALSE;
      $axis['textStyle']['fontSize'] = $value->getLabelsFontSize();
      $axis['slantedText'] = ($value->getLabelsRotation()) ? TRUE : NULL;
      $axis['slantedTextAngle'] = $value->getLabelsRotation();
      $axis['gridlines']['color'] = $value->getGridLineColor();
      $axis['baselineColor'] = $value->getBaseLineColor();
      $axis['minorGridlines']['color'] = $value->getMinorGridLineColor();
      $axis['viewWindowMode'] = ($value->getMax()) ? 'explicit' : NULL;
      $axis['viewWindow']['max'] = strlen($value->getMax()) ? (int) $value->getMax() : NULL;
      $axis['viewWindow']['min'] = strlen($value->getMin()) ? (int) $value->getMin() : NULL;

      // Multi-axis support only applies to the major axis in Google charts.
      $chart_type_info = $this->chart_get_type($this->chart->getChartType());
      $axis_index = $value->getOpposite() ? 1 : 0;
      if ($value->getType() === 'xaxis') {
        $axis_keys = !$chart_type_info['axis_inverted'] ? array('hAxis') : array('vAxes', $axis_index);
      }
      else {
        $axis_keys = !$chart_type_info['axis_inverted'] ? array('vAxes', $axis_index) : array('hAxis');
      }
      $axis_drilldown = & $options;
      foreach ($axis_keys as $key) {
        $axis_drilldown = & $axis_drilldown[$key];
      }
      $axis_drilldown = $axis;
    }

    return $chart_definition;
  }

  /**
   * Utility to populate chart data.
   */
  private function charts_google_populate_chart_data() {
    $chart_definition = array();
    $options['series'] = array();
    $chart_type_info = $this->chart_get_type($this->chart->getChartType());
    $series_number = 0;
    foreach ($this->chart->getData() as $key) {
      /** @var ChartsData $data */
      $data = $this->chart->getDataByKey($key);
      $series = array();

      // Convert target named axis keys to integers.
      $axis_index = 0;
      if ($data->getTargetAxis()) {
        $axis_name = $data->getTargetAxis();
        $multi_axis_type = $chart_type_info['axis_inverted'] ? 'getXaxis' : 'getYaxis';
        foreach ($this->chart->{$multi_axis_type}() as $axis_key => $axis_value) {
          if ($axis_key === $axis_name) {
            break;
          }
          $axis_index++;
          $series['targetAxisIndex'] = $axis_index;
        }
      }

      // Allow data to provide the labels. This will override the axis settings.
      if ($data->getLabels()) {
        foreach ($data->getLabels() as $label_index => $label) {
          $chart_definition['data'][$label_index + 1][0] = $label;
        }
      }

      if ($data->getTitle()) {
        $chart_definition['data'][0][$series_number + 1] = $data->getTitle();
      }
      foreach ($data->getData() as $index => $data_value) {
        // Nested array values typically used for scatter charts. This weird
        // approach leaves columns empty in order to make arbitrary pairings.
        // See https://developers.google.com/chart/interactive/docs/gallery/scatterchart#Data_Format
        if (is_array($data_value)) {
          $chart_definition['data'][] = array(
            0 => $data_value[0],
            $series_number + 1 => $data_value[1],
          );
        }
        // Most charts provide a single-dimension array of values.
        else {
          $chart_definition['data'][$index + 1][$series_number + 1] = $data_value;
        }
      }

      $series['color'] = $data->getColor();
      $series['pointSize'] = $data->getMarkerRadius();
      $series['visibleInLegend'] = $data->getShowInLegend();

      // Labels only supported on pies.
      $series['pieSliceText'] = $data->getShowLabels() ? 'label' : 'none';

      // These properties are not real Google Charts properties. They are
      // utilized by the formatter in charts_google.js.
      $decimal_count = $data->getDecimalCount() ? '.' . str_repeat('0', $data->getDecimalCount()) : '';
      $prefix = $this->charts_google_escape_icu_characters($data->getPrefix());
      $suffix = $this->charts_google_escape_icu_characters($data->getSuffix());
      $format = $prefix . '#' . $decimal_count . $suffix;
      $series['_format']['format'] = $format;

      // TODO: Convert this from PHP's date format to ICU format.
      // See https://developers.google.com/chart/interactive/docs/reference#dateformatter.
      //$series['_format']['dateFormat'] = $chart[$key]['#date_format'];

      // Conveniently only the axis that supports multiple axes is the one that
      // can receive formatting, so we know that the key will always be plural.
      $axis_type = $chart_type_info['axis_inverted'] ? 'hAxes' : 'vAxes';
      $options[$axis_type][$axis_index]['format'] = $format;

      // Convert to a ComboChart if mixing types.
      // See https://developers.google.com/chart/interactive/docs/gallery/combochart?hl=en.
      if ($data->getChartType()) {
        // Oddly Google calls a "column" chart a "bars" series. Using actual bar
        // charts is not supported in combo charts with Google.
        $main_chart_type = $this->chart->getChartType() === 'column' ? 'bars' : $this->chart->getChartType();
        $chart_definition['visualization'] = 'ComboChart';
        $options['seriesType'] = $main_chart_type;

        $data_chart_type = $data->getChartType() === 'column' ? 'bars' : $data->getChartType();
        $series['type'] = $data_chart_type;
      }

      // Add the series to the main chart definition.
      $this->charts_trim_array($series);
      $chart_definition['options']['series'][$series_number] = $series;

      // Merge in any point-specific data points.
      foreach ($data->getDataItem() as $key => $data_item) {
        if ($data_item->getData()) {
          $chart_definition['data'][$key + 1][$series_number + 1] = $data_item->getData();
        }
        // These data properties are manually applied to cells in JS.
        // Color role not yet supported. See https://code.google.com/p/google-visualization-api-issues/issues/detail?id=1267
        $chart_definition['_data'][$key + 1][$series_number + 1]['color'] = $data_item->getColor();
        $chart_definition['_data'][$key + 1][$series_number + 1]['tooltip'] = $data_item->getTitle();
        $this->charts_trim_array($chart_definition['_data'][$key + 1][$series_number + 1]);
      }

      $series_number++;
    }

    // Once complete, normalize the chart data to ensure a full 2D structure.
    $data = $chart_definition['data'];

    // Stub out corner value.
    $data[0][0] = isset($data[0][0]) ? $data[0][0] : 'x';

    // Ensure consistent column count.
    $column_count = count($data[0]);
    foreach ($data as $row => $values) {
      for ($n = 0; $n < $column_count; $n++) {
        $data[$row][$n] = isset($data[$row][$n]) ? $data[$row][$n] : NULL;
      }
      ksort($data[$row]);
    }
    ksort($data);

    $chart_definition['data'] = $data;

    return $chart_definition;
  }

  /**
   * Utility to escape special characters in ICU number formats.
   *
   * Google will use the ICU format to auto-adjust numbers based on special
   * characters that are used in the format. This function escapes these special
   * characters so they just show up as the character specified.
   *
   * The format string is a subset of the ICU pattern set. For instance,
   * {pattern:'#,###%'} will result in output values "1,000%", "750%", and "50%"
   * for values 10, 7.5, and 0.5.
   */
  private function charts_google_escape_icu_characters($string) {
    return preg_replace('/([0-9@#\.\-,E\+;%\'\*])/', "'$1'", $string);
  }

}
