USE SISTEMACAMPOALQUILER;

-- Prodemiento Registrar producto
DELIMITER $$ 
CREATE PROCEDURE registrar_Producto (
    IN p_nombre VARCHAR(100),
    IN p_precio DECIMAL(10, 2),
    IN p_cantidad INT,
    IN p_imagenProducto VARCHAR(255) -- Campo para almacenar la ruta de la imagen
)
BEGIN
    -- Si no se proporciona imagenProducto, se puede asignar NULL aquí
    IF p_imagenProducto IS NULL THEN
        SET p_imagenProducto = NULL;
    END IF;

    -- Insertamos los datos en la tabla productos
    INSERT INTO productos (nombre, precio, cantidad, imagenProducto, estado)
    VALUES (p_nombre, p_precio, p_cantidad, p_imagenProducto, 'activo');
END $$ 
DELIMITER ;

-- procedimiento listar producto
DELIMITER $$ 
CREATE PROCEDURE listar_Producto ()
BEGIN
    SELECT idproducto, nombre, precio, cantidad, estado
    FROM productos;
END $$ 
DELIMITER ;


-- procedimiento actualizar Producto
DELIMITER $$
CREATE PROCEDURE actualizar_Producto (
    IN p_idproducto INT,
    IN p_nombre VARCHAR(100),
    IN p_precio DECIMAL(10, 2),
    IN p_cantidad INT,
    IN p_imagenProducto VARCHAR(255),  -- Nueva imagen (opcional)
    IN p_estado ENUM('activo', 'inactivo')  -- Nuevo parámetro para el estado
)
BEGIN
    -- Actualizar los campos en la tabla productos
    UPDATE productos
    SET nombre = p_nombre,
        precio = p_precio,
        cantidad = p_cantidad,
        imagenProducto = p_imagenProducto,  -- Actualizar la imagen, si se proporciona
        estado = p_estado  -- Actualizar el estado
    WHERE idproducto = p_idproducto;
END $$ 
DELIMITER ;

-- procedimiento eliminar Producto
DELIMITER $$
CREATE PROCEDURE eliminar_Producto (
    IN p_idproducto INT
)
BEGIN
    DECLARE rutaImagen VARCHAR(255);

    -- Obtener la ruta de la imagen del producto
    SELECT imagenProducto INTO rutaImagen FROM productos WHERE idproducto = p_idproducto;

    -- Eliminar el producto de la base de datos
    DELETE FROM productos WHERE idproducto = p_idproducto;

    -- Aquí podrías añadir lógica adicional para eliminar la imagen del sistema de archivos si es necesario
    -- Por ejemplo, podrías usar la rutaImagen para borrar el archivo en el servidor

END $$ 
DELIMITER ;

-- Procedimiento Ver Producto
DELIMITER $$
CREATE PROCEDURE ver_producto(IN p_idproducto INT)
BEGIN
    SELECT 
        idproducto,
        nombre,
        precio,
        cantidad,
        imagenProducto,
        estado,
        create_at
    FROM 
        productos
    WHERE 
        idproducto = p_idproducto;
END $$
DELIMITER ;

DELIMITER $$ 
CREATE PROCEDURE mostrar_nombres_y_stock_productos()
BEGIN
    SELECT nombre, cantidad
    FROM productos
    WHERE estado = 'activo';  -- Solo productos activos
END $$ 
DELIMITER ;


DELIMITER $$ 
CREATE PROCEDURE mostrar_detalles_productos(
    IN p_nombre_producto VARCHAR(100),    -- Nombre del producto seleccionado
    IN p_cantidad_deseada INT             -- Cantidad deseada por el usuario
)
BEGIN
    SELECT precio, cantidad, idproducto
    FROM productos
    WHERE nombre = p_nombre_producto AND estado = 'activo'; -- Solo productos activos
END $$ 
DELIMITER ;



-- Agua minerales
CALL registrar_Producto('Agua Mineral Cielo 500ml', 2.00, 50, '../img/agua_mineral_cielo.jpg');
CALL registrar_Producto('Agua Mineral San Carlos 500ml', 2.20, 50, '../img/agua_mineral_sancarlos.jpg');
CALL registrar_Producto('Agua Mineral San Mateo 500ml', 2.20, 50, '../img/agua_mineral_sanmateo.jpg');
CALL registrar_Producto('Agua Mineral San Luis 500ml', 2.20, 50, '../img/agua_mineral_sanluis.jpg');
-- Bebidas energeticas
CALL registrar_Producto('Red Bull 250ml', 2.50, 100, '../img/bebida_energetica_redbull.jpg');
CALL registrar_Producto('Monster Energy 500ml', 3.00, 70, '../img/bebida_energetica_monsterenergy.jpg');
CALL registrar_Producto('Rockstar Energy 500ml', 3.00, 70, '../img/bebida_energetica_rockstarenergy.jpg');
CALL registrar_Producto('Burn Energy 500ml', 2.80, 60, '../img/bebida_energetica_burnenergy.jpg');
-- Bebidas gaseosas
CALL registrar_Producto('Coca-Cola 500ml', 3.50, 100, '../img/bebida_gaseosa_cocacola.jpg');
CALL registrar_Producto('Inka-Cola 500ml', 3.50, 100, '../img/bebida_gaseosa_incakola.jpg');
CALL registrar_Producto('Fanta Naranja 500ml', 2.00, 100, '../img/bebida_gaseosa_fanta.jpg');
CALL registrar_Producto('Sprite 500ml', 2.00, 100, '../img/bebida_gaseosa_sprite.jpg');
CALL registrar_Producto('Pepsi 500ml', 2.00, 100, '../img/bebida_gaseosa_pepsi.jpg');
-- Cervezas
CALL registrar_Producto('Cerveza Negra 500ml', 5.50, 100, '../img/cerveza_negracusqueña.jpg');
CALL registrar_Producto('Cerveza Pilsen 330ml', 6.50, 100, '../img/cerveza_pilsen.jpg');
CALL registrar_Producto('Cerveza Rubia 330ml', 6.50, 100, '../img/cerveza_rubiacusqueña.jpg');
CALL registrar_Producto('Cerveza Cristal 330ml', 6.20, 100, '../img/cerveza_cristal.jpg');


CALL mostrar_nombres_y_stock_productos();
CALL mostrar_detalles_productos('Agua Mineral Cielo 500ml', 5);
CALL listar_Producto();
CALL ver_producto(1);
CALL listar_Producto();




