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
$base_url = "/sites/ReportaCiudad/themes/lmdmc";
$userImage = null;
if(isset($user->picture)){
  $file = file_load($user->picture);
  if(isset($file) && isset($file->uri)){
    $userImage = theme('image', array(
    'path' => $file->uri,
    'alt' => 'User picture',
    ));
  }
}
?>
<div id="mobile-navigation">
  <a href="#" class="category-menu"><img src="/sites/ReportaCiudad/themes/lmdmc/img/reportaciudad_arriba.png"></a>
  <script>
  jQuery("a.category-menu").click(function(event){
    event.preventDefault();
    jQuery("nav").appendTo("#mobile-navigation");
    jQuery(".submenu").removeClass("show");
    jQuery("nav").toggleClass("show");
  });
  </script>
  <a href="/node/add/reportes" class="button">Reportar</a>
  <?php if ($logged_in): ?>
    <a href="/user/logout" class="button btn-warning">Salir</a>
  <?php else: ?>
    <a href="/user" class="button btn-info">Ingresar</a>
  <?php endif; ?>
</div>
<div class="main_nav column col-md-3">
  <h1><a href="/"><img src="/sites/ReportaCiudad/themes/lmdmc/logo.svg"></a></h1>
  <h3>
      VER REPORTES
  </h3>
  <nav>
    <a id="democracia_participacion_menu" class="democracia_participacion cat-menu" href="#">Democracia y participación</a>
    <a id="desarollo_urbano_menu" class="desarollo_urbano term-12 cat-menu" href="#">Desarrollo urbano sustentable</a>
    <a id="inclusion_equidad_menu" class="inclusion_equidad term-12 cat-menu" href="#">Inclusión y equidad</a>
  </nav>
  <a href="/como-funciona" class="button">¿CÓMO FUNCIONA?</a>
  <div class="bottom_nav">
      <ul>
        <li><a href="/contacto">Contacto</a></li>
        <li><a href="/acerca">Quiénes somos</a></li>
        <li><a href="/estadisticas">Estadísticas</a></li>
        <li><a href="/preguntas">Preguntas Frecuentes</a></li>
      </ul>
  </div>
</div>
<div class="overlay" style="display: none"><div id="report-over"></div></div>
<div class="main_area column col-md-7">
  <div class="row">
    <div class="main_header col-md-12">
      <a href="/node/add/reportes" class="button reportar">Reportar ahora</a>
    </div>
    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>

    <section<?php print $content_column_class; ?>>
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
      <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if (!empty($title) && !TRUE): ?>
        <h1 class="page-header"><?php print_r($node, TRUE); print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
    </section>

    <div id="democracia_participacion" class="submenu">
      <?php print views_embed_view('menu_category', 'block', 11); ?>
    </div>

    <div id="desarollo_urbano" class="submenu">
      <?php print views_embed_view('menu_category', 'block', 13); ?>
    </div>

    <div id="inclusion_equidad" class="submenu">
      <?php print views_embed_view('menu_category', 'block', 12); ?>
    </div>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>

  </div>
</div>
<div class="main_feed column col-md-2">
  <div class="row">
   <div class="main_login col-md-12">
      <div class="user">
        <?php if ($logged_in): ?>
          <p><a href="/user/logout">Salir</a></p>
          <a href="/user/<?php echo $user->uid; ?>/edit">
        <?php else: ?>
          <p><a href="/user">Ingresar</a></p>
          <a href="#">
        <?php endif; ?>
          <figure>
            <?php
            if(isset($userImage)){
              echo $userImage;
            }else{
            ?>
            <img src="<?php echo $base_url; ?>/img/icon-user.png">
            <?php } ?>
          </figure>
        </a>
      </div>
   </div>
   <div class="feed_container col-md-12">
     <?php // TODO: filtrar usuarios moderadores  ?>
     <?php print render(module_invoke('menu', 'block_view', 'menu-moderaci-n'));?>
      <div class="resume_feed">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class=""><a href="#tab_relevamientos" aria-controls="tab_relevamientos" role="tab" data-toggle="tab" aria-expanded="false">Resumen de relevamientos</a></li>
          <li role="presentation" class="active"><a href="#tab_mapeos" aria-controls="tab_mapeos" role="tab" data-toggle="tab" aria-expanded="true">Resumen de reportes</a></li>
        </ul>
        <?php
        $uri = explode('/', $_GET['q']);
        $result = '';
        if ( isset($uri['2']) && taxonomy_term_load($uri['2']) ) {
          $category = $uri['2'];
        }
        else {
          $category = 0;
        }
        ?>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane" id="tab_relevamientos">
            <?php
            if ( $category ) {
              print views_embed_view('resumen_relevamientos', 'default', $uri['2']);
            }
            else {
              print views_embed_view('resumen_relevamientos', 'default');
            }
            ?>
            <div class="reports_pormibarrio">
              <h3>Últimos relevamientos</h3>
              <?php
              if ( $category ) {
                print views_embed_view('ultimos_relevamientos', 'default', $uri['2']);
              }
              else {
                print views_embed_view('ultimos_relevamientos', 'default');
              }
              ?>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane active" id="tab_mapeos">
            <?php if ( $category ) {
              print views_embed_view('resumen_reportes', 'block', $uri['2']);
            }
            else {
              print views_embed_view('resumen_reportes', 'block_1');
            } ?>
            <div class="reports_pormibarrio">
              <h3>Últimos reportes</h3>
              <?php
              print views_embed_view('ultimo_reportes', 'block');
              //include('view--ultimos_reportes.tpl.php');
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (!empty($page['footer'])): ?>
  <footer class="footer <?php print $container_class; ?>">
    <?php print render($page['footer']); ?>
  </footer>
<?php endif; ?>
