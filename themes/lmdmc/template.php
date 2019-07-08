<?php
/**
 * @file
 * The primary PHP file for this theme.
 */
/*function lmdmc_node_add_list($content) {
  $output = '';
  if ($content) {
    $output = '<dl class="node-type-list">';
    foreach ($content as $item) {

      //The node type is not passed to this function, but I can get it from access
      //argument! which is something like array('create', 'node_type') !!
      $access_arguments = unserialize($item['access_arguments']);
      $node_type = $access_arguments[1];

      $output .= "<div class=\"node-add-{$node_type}-wrapper node-add-item-wrapper\">";
      $output .= "<div class=\"node-add-{$node_type}-inner node-add-item-inner\">";
      $output .= "<dt class=\"node-add-{$node_type}\">". l($item['title'], $item['href'], $item['localized_options']) .'</dt>';
      $output .= "<dd class=\"node-add-{$node_type}\">". filter_xss_admin($item['description']) .'</dd>';
      $output .= "</div><!-- /.node-add-{$node_type}-wrapper -->";
      $output .= "</div><!-- /.node-add-{$node_type}-inner -->";
    }
    $output .= '</dl><div style="clear: both;"></div>';
  }
  return $output;
}
*/
