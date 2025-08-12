<?php

require_once __DIR__ . '/Domain/ValueObject/Email.php';
require_once __DIR__ . '/Domain/ValueObject/Money.php';

require_once __DIR__ . '/Domain/Entity/Usuario.php';
require_once __DIR__ . '/Domain/Entity/Cliente.php';
require_once __DIR__ . '/Domain/Entity/Producto.php';
require_once __DIR__ . '/Domain/Entity/Pedido.php';
require_once __DIR__ . '/Domain/Entity/PedidoDetalle.php';
require_once __DIR__ . '/Domain/Entity/Categoria.php';
require_once __DIR__ . '/Domain/Entity/Proveedor.php';
require_once __DIR__ . '/Domain/Entity/MovimientoInventario.php';
require_once __DIR__ . '/Domain/Entity/Compra.php';
require_once __DIR__ . '/Domain/Entity/Pago.php';

require_once __DIR__ . '/Domain/Port/DatabaseConnectionInterface.php';
require_once __DIR__ . '/Domain/Port/UsuarioRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/ClienteRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/ProductoRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/PedidoRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/CategoriaRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/ProveedorRepositoryInterface.php';
require_once __DIR__ . '/Domain/Port/ImagenRepositoryInterface.php';

require_once __DIR__ . '/Infrastructure/Database/DatabaseConnection.php';
require_once __DIR__ . '/Infrastructure/Repository/UsuarioRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/ClienteRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/ProductoRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/CategoriaRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/ProveedorRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/ImagenRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/PedidoRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/CompraRepository.php';
require_once __DIR__ . '/Infrastructure/Repository/PagoRepository.php';

require_once __DIR__ . '/Application/UseCase/CrearUsuarioUseCase.php';
require_once __DIR__ . '/Application/UseCase/AutenticarUsuarioUseCase.php';
require_once __DIR__ . '/Application/UseCase/CrearClienteUseCase.php';
require_once __DIR__ . '/Application/UseCase/ObtenerProductosUseCase.php';
require_once __DIR__ . '/Application/UseCase/CrearProductoUseCase.php';
require_once __DIR__ . '/Application/UseCase/CrearCategoriaUseCase.php';
require_once __DIR__ . '/Application/UseCase/CrearProveedorUseCase.php';
require_once __DIR__ . '/Application/UseCase/ObtenerPedidosUseCase.php';
require_once __DIR__ . '/Application/UseCase/ObtenerInventarioUseCase.php';
require_once __DIR__ . '/Application/UseCase/ObtenerComprasUseCase.php';
require_once __DIR__ . '/Application/UseCase/ObtenerPagosUseCase.php';

class Bootstrap
{
    private $container = [];

    public function __construct()
    {
        $this->inicializarDependencias();
    }

    private function inicializarDependencias()
    {
        $this->container['db'] = new DatabaseConnection();
        
        $this->container['usuarioRepository'] = new UsuarioRepository($this->container['db']);
        $this->container['clienteRepository'] = new ClienteRepository($this->container['db']);
        $this->container['productoRepository'] = new ProductoRepository($this->container['db']);
        $this->container['categoriaRepository'] = new CategoriaRepository($this->container['db']);
        $this->container['proveedorRepository'] = new ProveedorRepository($this->container['db']);
        $this->container['imagenRepository'] = new ImagenRepository();
        $this->container['pedidoRepository'] = new PedidoRepository($this->container['db']);
        $this->container['compraRepository'] = new CompraRepository($this->container['db']);
        $this->container['pagoRepository'] = new PagoRepository($this->container['db']);
        
        $this->container['crearUsuarioUseCase'] = new CrearUsuarioUseCase($this->container['usuarioRepository']);
        $this->container['autenticarUsuarioUseCase'] = new AutenticarUsuarioUseCase($this->container['usuarioRepository']);
        $this->container['crearClienteUseCase'] = new CrearClienteUseCase($this->container['clienteRepository']);
        $this->container['obtenerProductosUseCase'] = new ObtenerProductosUseCase($this->container['productoRepository'], $this->container['categoriaRepository']);
        $this->container['crearProductoUseCase'] = new CrearProductoUseCase($this->container['productoRepository'], $this->container['imagenRepository']);
        $this->container['crearCategoriaUseCase'] = new CrearCategoriaUseCase($this->container['categoriaRepository']);
        $this->container['crearProveedorUseCase'] = new CrearProveedorUseCase($this->container['proveedorRepository']);
        $this->container['obtenerPedidosUseCase'] = new ObtenerPedidosUseCase($this->container['pedidoRepository']);
        $this->container['obtenerInventarioUseCase'] = new ObtenerInventarioUseCase($this->container['productoRepository']);
        $this->container['obtenerComprasUseCase'] = new ObtenerComprasUseCase($this->container['compraRepository']);
        $this->container['obtenerPagosUseCase'] = new ObtenerPagosUseCase($this->container['pagoRepository']);
    }

    public function get($service)
    {
        if (!isset($this->container[$service])) {
            throw new Exception("Servicio no encontrado: $service");
        }
        return $this->container[$service];
    }

    public function getUsuarioRepository()
    {
        return $this->get('usuarioRepository');
    }

    public function getClienteRepository()
    {
        return $this->get('clienteRepository');
    }

    public function getProductoRepository()
    {
        return $this->get('productoRepository');
    }

    public function getCategoriaRepository()
    {
        return $this->get('categoriaRepository');
    }

    public function getProveedorRepository()
    {
        return $this->get('proveedorRepository');
    }

    public function getCrearUsuarioUseCase()
    {
        return $this->get('crearUsuarioUseCase');
    }

    public function getAutenticarUsuarioUseCase()
    {
        return $this->get('autenticarUsuarioUseCase');
    }

    public function getCrearClienteUseCase()
    {
        return $this->get('crearClienteUseCase');
    }

    public function getObtenerProductosUseCase()
    {
        return $this->get('obtenerProductosUseCase');
    }

    public function getCrearProductoUseCase()
    {
        return $this->get('crearProductoUseCase');
    }

    public function getCrearCategoriaUseCase()
    {
        return $this->get('crearCategoriaUseCase');
    }

    public function getCrearProveedorUseCase()
    {
        return $this->get('crearProveedorUseCase');
    }

    public function getPedidoRepository()
    {
        return $this->get('pedidoRepository');
    }

    public function getObtenerPedidosUseCase()
    {
        return $this->get('obtenerPedidosUseCase');
    }

    public function getObtenerInventarioUseCase()
    {
        return $this->get('obtenerInventarioUseCase');
    }

    public function getCompraRepository()
    {
        return $this->get('compraRepository');
    }

    public function getObtenerComprasUseCase()
    {
        return $this->get('obtenerComprasUseCase');
    }

    public function getPagoRepository()
    {
        return $this->get('pagoRepository');
    }

    public function getObtenerPagosUseCase()
    {
        return $this->get('obtenerPagosUseCase');
    }
}