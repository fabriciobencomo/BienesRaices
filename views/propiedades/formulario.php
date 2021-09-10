<fieldset>
        <legend>Datos de la Propiedad</legend>
        
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo de Propiedad" value="<?php echo s($propiedad->titulo); ?>">

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio de Propiedad" value="<?php echo s($propiedad->precio); ?>">

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

        <?php if($propiedad->imagen): ?>
            <img src="/imagenes/<?php echo $propiedad->imagen?>" class="img-small" alt="">
        <?php endif; ?>

        <label for="descripcion">Descripci&oacute;n:</label>
        <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
    </fieldset>

    <fieldset>
        <legend>Informacion General</legend>

        <label for="habitaciones">Habitaciones:</label>
        <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

        <label for="wc">Baños:</label>
        <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

        <label for="estacionamiento">Estacionamientos:</label>
        <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
    </fieldset>

    <fieldset>
        <legend>Vendedor</legend>

        <select name="propiedad[vendedorId]" id="vendedor">
                <option value="" disabled selected>----Seleccionar-----</option>
                <?php foreach($vendedores as $vendedor): ?>
                    <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?> value="<?php echo s($vendedor->id)?>"> <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido) ?> </option>
                <?php endforeach; ?>
        </select>
</fieldset>

