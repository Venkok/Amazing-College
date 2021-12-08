<?php
get_header();
pageBanner(array(
  'title' => 'Past events',
  'subtitle' => 'A recap of our past events.'
))
?>

  <div class="container container--narrow page-section">
<?php


$today = date('Ymd'); # be sure to use the same format as Return Format in Field settings!

$pastEvents = new WP_Query(array(
  'paged' => get_query_var( 'paged', 1), /* this tells the Custom query which page number of results it should be on.
   */
  'post_type' => 'event',
  'meta_key' => 'event_date',
  'orderby' => 'meta_value_num', 
  'order' => 'ASC',
  'meta_query' => array(
    array( # shows only if event date is greater than or equal to today's date 
      'key' => 'event_date',
      'compare' => '<',
      'value' => $today,
      'type' => 'numeric'
    )
  )
));


  while ($pastEvents->have_posts()) { // keep looping as long as the following is true: 
    $pastEvents->the_post(); 

    get_template_part( 'template-parts/content', 'event');
    

 }
echo paginate_links(array(
    'total' => $pastEvents->max_num_pages
));

    ?>
  
  </div>


<?php get_footer(); ?>  