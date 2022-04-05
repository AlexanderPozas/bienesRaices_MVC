<main class="contenedor seccion contenido-centrado">
    <h1 data-cy="heading-contacto">Contacto</h1>

    <?php if($mensaje): ?>
        <p data-cy="alerta-envio-formulario" class="alerta exito"><?php echo $mensaje;?></p>
    <?php endif; ?>

    <picture>
        <source srcset="build/img/destacada3.avif" type="image/avif">
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen formulario">
    </picture>
    <h2 data-cy="heading-formulario">Llene el Formulario de Contacto</h2>
    <form data-cy="formulario-contacto" class="formulario" action="/contacto" method="POST">

        <fieldset>
            <legend>Informacion Personal</legend>
            <label for="nombre">Nombre</label>
            <input data-cy="input-nombre" type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required>

            <label for="mensaje">Mensaje</label>
            <textarea data-cy="input-mensaje" id="mensaje" name="contacto[mensaje]"></textarea>

        </fieldset>

        <fieldset>
            <legend>Información sobre propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select data-cy="input-opciones" id="tipo" name="contacto[tipo]">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input data-cy="input-precio" type="number" id="presupuesto" placeholder="Tu Precio o Presupuesto" name="contacto[presupuesto]">
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>
            <p>Cómo desea ser Contactado</p>
            <div class="contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input data-cy="forma-contacto" type="radio" name="contacto[contacto]" id="contactar-telefono" value="telefono">
                <label for="">E-mail</label>
                <input data-cy="forma-contacto" type="radio" name="contacto[contacto]" id="contactar-email" value="email">
            </div>
            <div id="contacto"></div> 
        </fieldset>
        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>