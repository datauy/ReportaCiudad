<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */
  $base_url = "/sites/default/themes/lmdmc";
?>
<div class="container-fluid">
  <div class="row">
        <div class="main_nav column col-md-3">

        <h1><a href="#"><img src="<?php echo $base_url; ?>/img/logo.svg"></a></h1>

        <h3>
            QUERÉS REPORTAR<br>
            FILTRÁ POR CATEGORÍAS
        </h3>

        <nav>
          <a class="democracia_participacion" href="#">Democracia y participación</a>
          <a class="desarollo_urbano" href="#">Desarrollo urbano sustentable</a>
          <a class="inclusion_equidad active" href="#">Inclusión y equidad</a>

        </nav>


        <a href="#" class="button">¿CÓMO FUNCIONA?</a>


        <div class="bottom_nav">
            <ul>
              <li><a href="/contacto">Contacto</a></li>
              <li><a href="/acerca">Quienes somos</a></li>
              <li><a href="/preguntas">Preguntas Frecuentes</a></li>
            </ul>
        </div>

        </div>
        <div class="main_area column col-md-7">

            <div class="row">
                 <div class="main_header col-md-12">

                    <a href="http://cordoba.development.datauy.org/around?latitude=-31.421993;longitude=-64.175616&zoom=2&list=0" class="button">Reportar ahora</a>
                    <?php if ($logged_in): ?>
                    <a href="#" class="button button_secondary">Relevar</a>
                    <?php endif; ?>

                 </div>

                 <div class="map_container col-md-12">

                   <div class="main_content_container">
                     <?php print render($page['content']); ?>
                   </div>

                        <div id="democracia_participacion" class="submenu">
                          <?php print views_embed_view('menu_category', 'block', 11); ?>
                        </div>

                        <div id="desarollo_urbano" class="submenu">
                          <?php print views_embed_view('menu_category', 'block', 13); ?>
                        </div>

                        <div id="inclusion_equidad" class="submenu">
                          <?php print views_embed_view('menu_category', 'block', 12); ?>
                        </div>




                        <div id="map">

                            <div class="search_input">
                              <input type="text" name="Comenzá tu busqueda" placeholder="Comenzá tu busqueda">
                              <a href="#">lupa</a>
                            </div>


                            <div class="map_tooltip">
                                <div class="map_tooltip_arrow"></div>
                                <i><img src="<?php echo $base_url; ?>/img/icon_seguridad.svg"></i>
                                <h4>INCLUSIÓN Y EQUIDAD</h4>
                                <span>CPC Centro Cultural San Vicente</span>
                            </div>


                        </div>

                 </div>

            </div>

              <div class="category_toast inclusion_equidad">
                   <div class="row">
                      <div class="col-md-6">
                        <i><img src="<?php echo $base_url; ?>/img/icon_seguridad.svg"></i>
                        <h4>INCLUSIÓN Y EQUIDAD</h4>
                        <span>Seguridad</span>
                      </div>

                       <div class="col-md-6">
                          <a class="objetives_button" href="#">Objetivos del plan de Metas</a>
                      </div>
                   </div>
                </div>


        </div>
        <div class="main_feed column col-md-2">

            <div class="row">
                 <div class="main_login col-md-12">

                    <div class="user">
                      <p>Ingresar</p>
                      <figure>
                        <img src="https://placeimg.com/50/50/people">
                      </figure>
                    </div>

                 </div>
                 <div class="feed_container col-md-12">

                      <div class="resume_feed">

                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_relevamientos" aria-controls="tab_relevamientos" role="tab" data-toggle="tab">Resumen de relevamientos</a></li>
                            <li role="presentation"><a href="#tab_mapeos" aria-controls="tab_mapeos" role="tab" data-toggle="tab">Resumen de mapeos</a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="tab_relevamientos">
                              <?php $block = module_invoke('datauy_cordoba', 'block_view', 'relevamientos');
                              print render($block['content']); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="tab_mapeos">
                              <?php $block_pmb = module_invoke('datauy_cordoba', 'block_view', 'pmb');
                              print render($block_pmb['content']); ?>
                            </div>
                          </div>

                        </div>


                      <div class="reports_pormibarrio">
                          <h3>Últimos Relevamientos</h3>
                          <?php print views_embed_view('ultimos_relevamientos', 'block'); ?>
                      </div>

                 </div>

            </div>

        </div>
  </div>
</div>
<!-- /container -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $base_url; ?>/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="<?php echo $base_url; ?>/js/vendor/bootstrap.min.js"></script>

<script src="<?php echo $base_url; ?>/js/main.js"></script>

 <script type="text/javascript">

  $('nav .democracia_participacion').click(function() {
      $('#democracia_participacion').toggleClass('show');
  });
  $('nav .desarollo_urbano').click(function() {
      $('#desarollo_urbano').toggleClass('show');
  });
  $('nav .inclusion_equidad').click(function() {
      $('#inclusion_equidad').toggleClass('show');
  });
</script>

<?php if (!empty($page['footer'])): ?>
  <footer class="footer <?php print $container_class; ?>">
    <?php print render($page['footer']); ?>
  </footer>
<?php endif; ?>
