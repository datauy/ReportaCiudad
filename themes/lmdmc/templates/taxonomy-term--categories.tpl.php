<?php

/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */
  $remoteGroups = "";
  if(isset($term->field_remote_groups) && isset($term->field_remote_groups['und'])){
   foreach ($term->field_remote_groups['und'] as $key => $group) {
     $remoteGroups .= $group['value'] . ",";
   }
  }
  $remoteGroups = rtrim($remoteGroups,",");
  if($remoteGroups){
   variable_set("remoteGroups",$remoteGroups);
  }
  $parents = taxonomy_get_parents($term->tid);
  $parent_name = null;
  foreach ($parents as $key => $parent) {
    if($parent_name==null){
          $parent_name = $parent->name;
    }
  }
  $cssParentClass = "";
  if($parent_name=="Inclusión y equidad"){
    $cssParentClass = "inclusion_equidad";
  }else if($parent_name=="Desarrollo Institucional"){
    $cssParentClass = "democracia_participacion";
    $parent_name = "Democracia y participación";
  }else if($parent_name=="Desarrollo Urbano sustentable"){
    $cssParentClass = "desarollo_urbano";
  }
?>
<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">
  <div id="categories-map">
    <?php print views_embed_view('base_category_map', 'block', $term->tid); ?>
  </div>
  <div class="category_toast <?php echo $cssParentClass; ?>">
     <div class="row">
        <div class="col-md-6 category-desc">
          <h4><?php echo strtoupper($parent_name); ?></h4>
          <span><?php echo $term->name; ?></span>
        </div>
         <div class="col-md-6 show-objectives">
            <a class="objetives_button show" href="#">Conocé las metas que propone el Gobierno municipal</a>
        </div>
     </div>
  </div>
  <?php if($remoteGroups!=""){ ?>
    <script type="text/javascript">
      var remotePMBGroups = '<?php echo $remoteGroups;?>';
      Drupal.behaviors.remotePMBGroups = '<?php echo $remoteGroups;?>';
      var parentName = '<?php echo $parent_name;?>';
      Drupal.behaviors.parentName = '<?php echo $parent_name;?>';
    </script>
  <?php }else{ ?>
    <script type="text/javascript">
      var remotePMBGroups = null;
      Drupal.behaviors.remotePMBGroups = null;
      var parentName = '<?php echo $parent_name;?>';
      Drupal.behaviors.parentName = '<?php echo $parent_name;?>';
    </script>
  <?php } ?>
</div>
<div class="objetivos_table">
  <div id="categories-municipio">
  <?php print views_embed_view('objetivos', 'block', $term->tid); ?>
</div>
</div>
<?php if ( isset($_GET['load_nid']) && $_GET['load_nid'] ): ?>
  <script>
    jQuery(document).ready(function(){
      jQuery.ajax({
        type: 'GET',
        url: "/node-view/<?php print $_GET['load_nid']; ?>",
        success: function(data, textStatus, response){
          jQuery('#report-over').empty();
          jQuery('#report-over').append(data);
          jQuery('.overlay').show();
        }
      });
    });
  </script>
<?php endif; ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
