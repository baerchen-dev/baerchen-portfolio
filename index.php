<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 md:px-8 py-16">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article class="mb-16">
      <h1 class="font-extrabold text-5xl md:text-7xl uppercase tracking-titulo mb-6"><?php the_title(); ?></h1>
      <!-- Estilo de lectura PROVISIONAL para el contenido del editor (hasta diseñar las plantillas) -->
      <div class="max-w-2xl text-lg md:text-xl leading-texto text-ink/80
                  [&_p]:mb-6
                  [&_h1]:font-bold [&_h1]:tracking-titulo [&_h1]:text-4xl [&_h1]:leading-tight [&_h1]:text-ink [&_h1]:mt-12 [&_h1]:mb-6
                  [&_h2]:font-bold [&_h2]:tracking-titulo [&_h2]:text-3xl [&_h2]:leading-tight [&_h2]:text-ink [&_h2]:mt-12 [&_h2]:mb-4
                  [&_h3]:font-bold [&_h3]:tracking-titulo [&_h3]:text-2xl [&_h3]:leading-snug [&_h3]:text-ink [&_h3]:mt-10 [&_h3]:mb-3
                  [&_ol]:list-decimal [&_ul]:list-disc [&_ol]:pl-6 [&_ul]:pl-6 [&_ol]:mb-6 [&_ul]:mb-6 [&_li]:mb-2
                  [&_code]:font-mono [&_code]:text-base [&_code]:text-ink"><?php the_content(); ?></div>
    </article>
  <?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>
