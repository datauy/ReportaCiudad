<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
$args = explode('/', $_GET['q']);
array_shift($args);
if ( isset($args['0']) )
  drupal_add_js('var apiArgs = '.$args['0'].';', 'inline');
?>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php $theme_path = drupal_get_path('theme', 'lmdmc'); ?>
  <div id="chart-container">
    <script type="text/javascript" src="/<?php print $theme_path; ?>/js/d3.v3.min.js" ></script>
    <script src="/<?php print $theme_path; ?>/js/jquery-ui-1.10.3.custom.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/<?php print $theme_path; ?>/js/stats.js" ></script>
    <link rel="stylesheet" href="/<?php print $theme_path; ?>/css/jquery-ui-1.10.3.custom.min.css">

    <h3 style="margin-top: 4%; text-align: center;">Visualizando desde <span id="date_from"></span> hasta <span id="date_to"></span></h3>
    <div id="graphs">

      <div class="graph-totals-values" class="chart-group">
        <h4 class="graph-title">TOTALES</h4>
        <div id="graph-total-users">
          <h3 id="graph-total-users-value"></h3>
          <p>Usuarios activos</p>
        </div>
        <div id="graph-total-reports">
          <h3 id="graph-total-reports-value"></h3>
          <p>Posteos online</p>
        </div>
      </div>

      <div class="graph-reports-per-categories" class="chart-group">
        <h4 class="graph-title">REPORTES POR CATEGORÍA</h4>
        <div id="graph-reports-categories">
        </div>
        <div id="graph-reports-categories-legend">
          <ul id="categories-list">
          </ul>
        </div>
      </div>

      <div class="graph-reports-by-state" class="chart-group">
        <h4 id="graph-reports-by-state-title" class="graph-title">REPORTES POR ESTADO</h4>
        <table id="graph-reports-by-state-table" class="graph-reports-by-state-table">
        </table>
      </div>

      <div style="display:none;" class="graph-reports-evolution" class="chart-group">
        <h4 class="graph-title">EVOLUCIÓN DE RECLAMOS</h4>
        <div id="graph-reports-evolution-chart">
          <svg id="graph-reports-evolution-chart-visualisation" width="100%" height="250"></svg>
        </div>
        <ul id="categories-list-evolution">
        </ul>
      </div>

    </div>
  </div>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>
</div><?php /* class view */ ?>
