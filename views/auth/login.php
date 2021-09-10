<main class="contenedor seccion contenido-centrado">
    <?php foreach($errores as $error):?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach?>
    <h1>Iniciar Sesion</h1>

    <form method="POST" class="formulario" novalidate action="/login">
        <fieldset>
            <legend>Email y Contraseña</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Tu Contraseña" id="password" required>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </fieldset>
    </form>
</main>