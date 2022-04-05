<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <!--Se muestran los errores en div-->
    <?php foreach ($errores as $error) : ?>
        <div class="error alerta">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST"">
        <!-- action: donde se envían los datos, a los input se añade la propiedad name -->
        <!-- method: $_GET: Se agrega los datos del formulario al url, no para logins (pasar info entre paginas)  -->
        <!-- method: $_POST: Arreglo asociativo, No se exponen los datos en el url (logins)   -->
        <?php include 'formulario.php' ?>

        <input type="submit" value="Actualizar Vendedor(a)" class="boton boton-verde">

    </form>

</main>