<main class="contenedor seccion">
    <h1>Crear</h1>
    <!--Se muestran los errores en div-->
    <?php foreach ($errores as $error) : ?>
        <div class="error alerta">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php" ?>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main>