<div class="event-summary post-item">
  <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
    <?php $event_date = DateTime::createFromFormat( "d/m/Y", get_field( "event_date" ) ); ?>
    <span class="event-summary__month">
      <?php echo $event_date->format("M"); ?></span>
    <span class="event-summary__day">
      <?php echo $event_date->format("d"); ?></span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h5>
    <p>
      <?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_excerpt(), 20 ); ?><br />
      <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
    </p>
  </div>
</div>
