CREATE DATABASE IF NOT EXISTS gestion_ventas;

-- ------------------------------------------------------------
-- 1. USUARIOS
-- ------------------------------------------------------------
CREATE TABLE usuarios (
    id_usuario      INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(100)            NOT NULL,
    email           VARCHAR(255)            NOT NULL UNIQUE,
    password_hash   CHAR(60)                NOT NULL,
    rol             VARCHAR(50)             NOT NULL DEFAULT 'vendedor',
    created_at      TIMESTAMP               DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 2. CATEGORIAS (autorreferenciada para sub-categorías)
-- ------------------------------------------------------------
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100)  NOT NULL,
    descripcion  TEXT,
    parent_id    INT           NULL,
    activo       TINYINT(1)    DEFAULT 1,
    FOREIGN KEY (parent_id) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 3. PROVEEDORES
-- ------------------------------------------------------------
CREATE TABLE proveedores (
    id_proveedor     INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa   VARCHAR(150) NOT NULL,
    contacto_nombre  VARCHAR(100) NOT NULL,
    email            VARCHAR(255),
    ruc              VARCHAR(20) UNIQUE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 4. PRODUCTOS
-- ------------------------------------------------------------
CREATE TABLE productos (
    id_producto  INT AUTO_INCREMENT PRIMARY KEY,
    codigo_sku   VARCHAR(50)   NOT NULL UNIQUE,
    nombre       VARCHAR(150)  NOT NULL,
    categoria_id INT           NOT NULL,
    proveedor_id INT           NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria),
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id_proveedor)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 5. CLIENTES
-- ------------------------------------------------------------
CREATE TABLE clientes (
    id_cliente  INT AUTO_INCREMENT PRIMARY KEY,
    tipo_cliente ENUM('natural','juridico') DEFAULT 'natural',
    nombre      VARCHAR(150) NOT NULL,
    email       VARCHAR(255),
    ruc_dni     VARCHAR(20)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 6. PEDIDOS
-- ------------------------------------------------------------
CREATE TABLE pedidos (
    id_pedido      INT AUTO_INCREMENT PRIMARY KEY,
    numero_pedido  VARCHAR(50)  NOT NULL UNIQUE,
    cliente_id     INT          NOT NULL,
    usuario_id     INT          NOT NULL,
    estado         ENUM('pendiente','procesando','completado','cancelado')
                   DEFAULT 'pendiente',
    fecha          TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_cliente),
    FOREIGN KEY (usuario_id)  REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 7. PEDIDO_DETALLES
-- ------------------------------------------------------------
CREATE TABLE pedido_detalles (
    id_detalle      INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id       INT          NOT NULL,
    producto_id     INT          NOT NULL,
    cantidad        INT          NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id)   REFERENCES pedidos(id_pedido)   ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 8. PAGOS
-- ------------------------------------------------------------
CREATE TABLE pagos (
    id_pago      INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id    INT          NOT NULL,
    cliente_id   INT          NOT NULL,
    monto        DECIMAL(10,2) NOT NULL,
    metodo_pago  ENUM('efectivo','tarjeta','transferencia','otro')
                 DEFAULT 'efectivo',
    fecha        TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id)  REFERENCES pedidos(id_pedido),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_cliente)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 9. MOV_INVENTARIO
-- ------------------------------------------------------------
CREATE TABLE mov_inventario (
    id_movimiento  INT AUTO_INCREMENT PRIMARY KEY,
    producto_id    INT          NOT NULL,
    tipo_movimiento ENUM('entrada','salida','ajuste') NOT NULL,
    cantidad       INT          NOT NULL,
    usuario_id     INT          NOT NULL,
    fecha          TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto),
    FOREIGN KEY (usuario_id)  REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 10. COMPRAS
-- ------------------------------------------------------------
CREATE TABLE compras (
    id_compra      INT AUTO_INCREMENT PRIMARY KEY,
    numero_compra  VARCHAR(50)  NOT NULL UNIQUE,
    proveedor_id   INT          NOT NULL,
    usuario_id     INT          NOT NULL,
    estado         ENUM('pendiente','recibido','cancelado') DEFAULT 'pendiente',
    fecha          TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id_proveedor),
    FOREIGN KEY (usuario_id)   REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 11. COMPRA_DETALLES
-- ------------------------------------------------------------
CREATE TABLE compra_detalles (
    id_detalle       INT AUTO_INCREMENT PRIMARY KEY,
    compra_id        INT          NOT NULL,
    producto_id      INT          NOT NULL,
    cantidad_pedida  INT          NOT NULL,
    precio_unitario  DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (compra_id)   REFERENCES compras(id_compra) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto)
) ENGINE=InnoDB;
