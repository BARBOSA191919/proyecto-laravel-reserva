document.addEventListener('DOMContentLoaded', function () {
    const triangulo = document.getElementById('miTriangulo');
    const menuCategorias = document.getElementById('menuCategorias');
    const botonCategorias = document.getElementById('botonCategorias');
    const menuCarrito = document.getElementById('menu-carrito');
    const carritoIcono = document.querySelector('.carrito');
    const itemsCarritoDiv = document.getElementById('items-carrito');
    const totalCarritoSpan = document.getElementById('total-carrito');
    const formAgregarCarrito = document.getElementById('form-agregar-carrito');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Menú de categorías
    if (botonCategorias && menuCategorias && triangulo) {
        botonCategorias.addEventListener('click', function (event) {
            event.stopPropagation();
            triangulo.classList.toggle('rotar');
            menuCategorias.style.display = menuCategorias.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', function () {
            if (menuCategorias.style.display === 'block') {
                menuCategorias.style.display = 'none';
                triangulo.classList.remove('rotar');
            }
        });
    }

    // Carrito de compras
    if (carritoIcono && menuCarrito) {
        carritoIcono.addEventListener('click', function(event) {
            event.preventDefault();
            menuCarrito.classList.toggle('oculto');
            if (!menuCarrito.classList.contains('oculto')) {
                cargarCarrito();
            }
        });
    }

    // Formulario de agregar al carrito
    if (formAgregarCarrito) {
        formAgregarCarrito.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(formAgregarCarrito);
            const eventoId = formData.get('evento_id');
            const cantidadEntradas = formData.get('cantidad_entradas');

            fetch(`/carrito/agregar/${eventoId}`, {
                method: 'POST',
                body: JSON.stringify({ evento_id: eventoId, cantidad_entradas: cantidadEntradas }),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '/login';
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.mensaje) {
                    alert(data.mensaje);
                    actualizarContadorCarrito(data.total_items);
                    cargarCarrito();
                }
            })
            .catch(error => {
                console.error('Error al añadir al carrito:', error);
                alert('Hubo un error al añadir al carrito.');
            });
        });
    } else {
        console.error('¡ERROR! El formulario con ID "form-agregar-carrito" no se encontró.');
    }

    function cargarCarrito() {
        itemsCarritoDiv.innerHTML = '';
        let total = 0;
        fetch('/carrito/obtener')
            .then(response => {
                if (!response.ok) {
                    window.location.href = '/login';
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
                            <p class="carrito-item-precio">$${item.precio * item.cantidad}</p>
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
                if (data) {
                    actualizarContadorCarrito(data.total_items);
                    totalCarritoSpan.textContent = `Total: $${total.toFixed(2)}`;
                }
            })
            .catch(error => {
                console.error('Error al cargar el carrito:', error);
                alert('Hubo un error al cargar el carrito.');
            });
    }

    function actualizarContadorCarrito(totalItems) {
        function intentarActualizar() {
            const carritoContadorLocal = document.getElementById('carrito-contador');
            if (carritoContadorLocal) {
                if (totalItems > 0) {
                    carritoContadorLocal.textContent = totalItems;
                    carritoContadorLocal.classList.remove('oculto');
                } else {
                    carritoContadorLocal.classList.add('oculto');
                }
            } else {
                console.error('¡ERROR! No se encontró el elemento con ID "carrito-contador" en actualizarContadorCarrito (intento).');
                // Intentar de nuevo después de un breve retraso (solo la primera vez)
                if (!intentarActualizar.intentado) {
                    intentarActualizar.intentado = true;
                    setTimeout(intentarActualizar, 100); // Espera 100 milisegundos
                }
            }
        }
        intentarActualizar.intentado = false; // Inicializa la bandera DENTRO de la función
        intentarActualizar();
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

    // Carga inicial del carrito al cargar la página (si el usuario está logueado)
    if (carritoIcono) {
        cargarCarrito();
    }
});