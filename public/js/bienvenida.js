document.addEventListener('DOMContentLoaded', function () {
    const triangulo = document.getElementById('miTriangulo');
    const menuCategorias = document.getElementById('menuCategorias');
    const botonCategorias = document.getElementById('botonCategorias');

    // Menú de categorías (tu código existente)
    if (botonCategorias && menuCategorias && triangulo) {
        botonCategorias.addEventListener('click', function (event) {
            event.stopPropagation();
            triangulo.classList.toggle('rotar');
            if (menuCategorias.style.display === 'block') {
                menuCategorias.style.display = 'none';
            } else {
                menuCategorias.style.display = 'block';
            }
        });

        window.addEventListener('click', function () {
            if (menuCategorias.style.display === 'block') {
                menuCategorias.style.display = 'none';
                triangulo.classList.remove('rotar');
            }
        });
    }

    // Funcionalidad del carrito para usuarios logueados (con logs para depuración)
    setTimeout(function() {
        const menuCarritoLocal = document.getElementById('menu-carrito');
        const carritoIconoLocal = document.querySelector('.carrito'); // Selecciona el carrito (solo existirá para usuarios logueados)

        console.log('menuCarritoLocal:', menuCarritoLocal);
        console.log('carritoIconoLocal:', carritoIconoLocal);

        if (menuCarritoLocal && carritoIconoLocal) {
            const itemsCarritoDiv = document.getElementById('items-carrito');
            const totalCarritoSpan = document.getElementById('total-carrito');
            const carritoContador = document.getElementById('carrito-contador');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            carritoIconoLocal.addEventListener('click', function(event) {
                event.preventDefault();
                menuCarritoLocal.classList.toggle('oculto');
                if (!menuCarritoLocal.classList.contains('oculto')) {
                    cargarCarrito();
                }
            });

            function cargarCarrito() {
                itemsCarritoDiv.innerHTML = '';
                let total = 0;
                fetch('/carrito/obtener')
                    .then(response => {
                        if (!response.ok) {
                            console.error('Error al obtener el carrito');
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.carrito) {
                            for (const itemId in data.carrito) {
                                const item = data.carrito[itemId];
                                const itemDiv = document.createElement('div');
                                itemDiv.classList.add('carrito-item');
                                itemDiv.style.position = 'relative';
                                itemDiv.innerHTML = `
                                    <img src="${item.imagen}" alt="${item.nombre}" class="carrito-imagen">
                                    <div class="carrito-item-info">
                                        <p class="carrito-item-nombre">${item.nombre}</p>
                                        <p class="carrito-item-cantidad">Asientos: ${item.cantidad}</p>
                                        <p class="carrito-item-fecha">Fecha: ${new Date(item.fecha).toLocaleDateString()}</p>
                                        ${item.edad ? `<p class="carrito-item-edad">Edad: ${item.edad} años</p>` : ''}
                                    </div>
                                    <img src="/img/borrar.png" alt="Borrar" class="borrar-item" data-item-id="${itemId}">
                                    <p class="carrito-item-precio">$${item.precio}</p>
                                `;
                                itemsCarritoDiv.appendChild(itemDiv);
                                total += item.precio * item.cantidad;

                                const botonBorrar = itemDiv.querySelector('.borrar-item');
                                if (botonBorrar) {
                                    botonBorrar.addEventListener('click', function() {
                                        const itemIdToDelete = this.getAttribute('data-item-id');
                                        eliminarItemCarrito(itemIdToDelete);
                                    });
                                }
                            }
                        }
                        totalCarritoSpan.textContent = `Total: $${total.toFixed(2)}`;
                        actualizarContadorCarrito(data ? data.total_items : 0);
                    })
                    .catch(error => {
                        console.error('Error al cargar el carrito:', error);
                        alert('Hubo un error al cargar el carrito.');
                    });
            }

            function actualizarContadorCarrito(totalItems) {
                const carritoContadorLocal = document.getElementById('carrito-contador');
                if (carritoContadorLocal) {
                    if (totalItems > 0) {
                        carritoContadorLocal.textContent = totalItems;
                        carritoContadorLocal.classList.remove('oculto');
                    } else {
                        carritoContadorLocal.classList.add('oculto');
                    }
                }
            }

            function eliminarItemCarrito(itemId) {
                fetch(`/carrito/eliminar/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.mensaje) {
                        alert(data.mensaje);
                        actualizarContadorCarrito(data.total_items);
                        cargarCarrito();
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar del carrito:', error);
                    alert('Hubo un error al eliminar el item del carrito.');
                });
            }

            // Cargar el carrito al cargar la página si el usuario está logueado
            cargarCarrito();
        } else {
            console.log('¡ADVERTENCIA! No se encontraron menuCarritoLocal o carritoIconoLocal en el setTimeout en bienvenida.js');
        }
    }, 0);
});

// Funcionalidad para el menú de ciudades
document.addEventListener('DOMContentLoaded', function () {
    const botonCiudades = document.getElementById('botonCiudades');
    const menuCiudades = document.getElementById('menuCiudades');
    const trianguloCiudades = document.getElementById('trianguloCiudades');

    if (botonCiudades && menuCiudades && trianguloCiudades) {
        // Cargar ciudades dinámicamente desde el servidor
        fetch('/ciudades')
            .then(response => response.json())
            .then(ciudades => {
                menuCiudades.innerHTML = ''; // Limpiar el menú
                ciudades.forEach(ciudad => {
                    const enlace = document.createElement('a');
                    enlace.classList.add('titulo-ciudades');
                    enlace.href = `/eventos/ciudad/${encodeURIComponent(ciudad)}`;
                    enlace.textContent = ciudad;
                    menuCiudades.appendChild(enlace);
                });
            })
            .catch(error => {
                console.error('Error al cargar ciudades:', error);
            });

        // Toggle del menú de ciudades
        botonCiudades.addEventListener('click', function (event) {
            event.stopPropagation();
            trianguloCiudades.classList.toggle('rotar');
            menuCiudades.style.display = menuCiudades.style.display === 'block' ? 'none' : 'block';
        });

        // Cerrar el menú al hacer clic fuera
        window.addEventListener('click', function () {
            if (menuCiudades.style.display === 'block') {
                menuCiudades.style.display = 'none';
                trianguloCiudades.classList.remove('rotar');
            }
        });
    }
});