</main>

<?php $email = 'info@baerchen.dev'; ?>

<!-- ============================================================ FOOTER ============================================================
 * Retícula (Figma): móvil 4 columnas + 16px de medianil · lg+ 12 columnas de 72px + 32px = 1216px (max-w-7xl px-8)
 * Escritorio (lg+): logo en las columnas 1–4 (abajo) · bloque de contenido en las columnas 5–12
 * Móvil: todo apilado y el logo al final, como firma
-->
<footer class="bg-ink text-bg" data-fondo="oscuro">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-7.5">
    <div class="grid grid-cols-4 gap-x-4 gap-y-16 lg:grid-cols-12 lg:gap-x-8">

      <!-- CONTENIDO · columnas 5–12 -->
      <div class="col-span-4 lg:col-start-5 lg:col-span-8 lg:row-start-1 flex flex-col gap-20">

        <!-- NAVEGACIÓN · SOCIAL · LEGAL -->
        <div class="grid grid-cols-2 gap-x-4 gap-y-12 sm:grid-cols-3 sm:gap-x-8">
          <?php get_template_part( 'components/footer-columna', null, array( 'titulo' => __( 'Navegación', 'baerchen' ), 'ubicacion' => 'main-menu' ) ); ?>
          <?php get_template_part( 'components/footer-columna', null, array( 'titulo' => __( 'Social', 'baerchen' ),     'ubicacion' => 'footer-social' ) ); ?>
          <?php get_template_part( 'components/footer-columna', null, array( 'titulo' => __( 'Legal', 'baerchen' ),      'ubicacion' => 'footer-legal' ) ); ?>
        </div>

        <!-- CONTACTO -->
        <div class="flex flex-col gap-6">
          <p class="font-mono font-bold text-lg uppercase tracking-wider leading-none text-bg/60"><?php esc_html_e( 'Contacto', 'baerchen' ); ?></p>
          <a href="<?php echo esc_url( 'mailto:' . $email ); ?>" class="self-start font-bold text-2xl md:text-[2rem] leading-none cursor-pointer hover:opacity-60 transition-opacity duration-300 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
            <?php echo esc_html( $email ); ?>
          </a>
        </div>

        <!-- COPYRIGHT -->
        <p class="font-mono font-bold text-sm md:text-base uppercase tracking-wider leading-snug text-bg/60">
          &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> · <?php esc_html_e( 'Francisco Estévez · Todos los derechos reservados', 'baerchen' ); ?>
        </p>

      </div>

      <!-- LOGO · columnas 1–4, abajo (en móvil va al final) -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="col-span-4 lg:col-start-1 lg:col-span-4 lg:row-start-1 self-end justify-self-start font-extrabold text-5xl lg:text-[3.5rem] uppercase tracking-titulo leading-none focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-current">
        <?php bloginfo( 'name' ); ?>
      </a>

    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
