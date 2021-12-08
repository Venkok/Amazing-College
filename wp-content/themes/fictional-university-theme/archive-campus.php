<?php
get_header();
pageBanner(array(
  'title' => 'All Campuses',
  'subtitle' => 'We have two campuses.'
))

?>

  <div class="container container--narrow page-section">

<div class="acf-map">

<?php
  while (have_posts()) { // keep looping as long as the following is true: 
  the_post(); 
  $mapLocation = get_field('map_location');
  
  ?>

<div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php echo $mapLocation['address']; ?>
</div>

  <?php } ?>
</div>

<hr class="section-break">

<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events')?>">Check out our past events archive.</a></p>

  </div>


<?php get_footer(); ?>  