<main class="contenedor seccion">
    <h2 data-cy="heading-nosotros">Más Sobre Nosotros</h2>
    <?php @include 'iconos.php' ?>
</main>

<section class="seccion contenedor">
    <h2 data-cy="heading-propiedades">Casas y Depas en Venta</h2>
    <?php
    @include 'listado.php';
    ?>
    <div class="alinear-derecha">
        <a href="/propiedades" class="boton-verde" data-cy="all-propr">Ver Todas</a>
    </div>
</section>

<section class="banner seccion">
    <div class="contenido-banner contenedor" data-cy="banner-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>
        <div class="alinear-centro">
            <a href="/contacto" class="boton-banner">Contactános</a>
        </div>
    </div>
</section>

<div class="blog seccion contenedor">
    <section data-cy="blog" class="contenedor-blog">
        <h2>Nuestro Blog</h2>
        <div class="nuestro-blog">
            <div class="imagen-blog">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img src="build/img/blog1.jpg" alt="Imagen del Blog">
                </picture>
            </div>
            <div class="contenido-blog">
                <a href="/entrada">
                    <h4>Terraza en el techo de tu casa</h4>
                    <blockquote class="informacion-meta">Escrito el: <span>02/02/2022</span> por admin: <span>Eduardo Pozas</span></blockquote>
                    <p>Consejos para construir una terraza en el techo de tu casa, con los mejores materiales y ahorrando dinero</p>
                </a>
            </div>
        </div>

        <div class="nuestro-blog">
            <div class="imagen-blog">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img src="build/img/blog2.jpg" alt="Imagen del Blog">
                </picture>
            </div>
            <div class="contenido-blog">
                <a href="/entrada">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <blockquote class="informacion-meta">Escrito el: <span>02/02/2022</span> por admin: <span>Eduardo Pozas</span></blockquote>
                    <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores para darle espacio a tu vida</p>
                </a>
            </div>
        </div>
    </section>
    <section data-cy="testimoniales" class="testimoniales">
        <h2>Testimoniales</h2>
        <div class="testimonio">
            <blockquote>
                El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cuenta con todas mis expectativas
            </blockquote>
            <p>- Eduardo Pozas</p>
        </div>
    </section>
</div>