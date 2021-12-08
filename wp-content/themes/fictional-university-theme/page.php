<?php get_header();

while (have_posts()) {
  the_post();

  pageBanner();

?>

  <div class="container container--narrow page-section">

    <?php
    $theParent = wp_get_post_parent_id(get_the_ID()); // берём ID текущей страницы и узнаём ID страницы-родителя
    if ($theParent) { ?>

      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
      </div>
    <?php }
    ?>

    <?php

    $testArray = get_pages(array(
      'child_of' => get_the_ID() /* if the current page has children function get_pages will return a collection of any and all children pages
or the the current page doesn't have have children fuction get_apges won't return anything, it will return NULL (which will be FALSE in if statement) */
    ));

    if ($theParent or $testArray) {  ?>
      <!-- 1) execute the code below if the current page has a parent or it is a Parent page. Этот код нужен для того, чтобы менюшка не отображалась на страницах, которые ни являются ни Parent ни Child (напр. Test 1 page) ; 2) exit php mode because the html begins   -->

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
          <?php

          if ($theParent) {
            $findChildrenOf = $theParent; // if we are on a child page
          } else {
            $findChildrenOf = get_the_ID(); // if we are on a Parent page
          }

          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order' // set column order in WP admin (Page Attributes - Order)
          ));
          ?>
        </ul>
      </div>

    <?php } ?>


    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>


<?php }

get_footer();
?>