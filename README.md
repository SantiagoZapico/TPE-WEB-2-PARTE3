# **PRADO INDUMENTARIA**

### - Descripción

Esta es una API RESTful fácil de usar que permite utilizar los servicios para un ABM, un filtrado y un ordenamiento de prendas y sus detalles mediante una base de datos.

La base de datos cuenta con dos tablas:

*tablaprendas*: Se utiliza para agregar prendas.

*detallesprenda*: Se utiliza para obtener más detalles de las prendas de *tablaprendas*. 

Utilizamos los siguiente códigos de respuesta:

    200 => "OK"
    201 => "Created"
    400 => "Bad Request"
    404 => "Not found"
    500 => "Internal Server Error"

### - ¿Cómo utilizar?

Para utilizar nuestra API, es necesario importar la base de datos a phpmyadmin desde la carpeta *database*. 
Se recomienda utilizar POSTMAN para probar cada endpoint a continuación. 

‎------------

### - Endpoints

Endpoint GET para ver toda la tabla:

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles

‎------------

Endpoint GET para ver por un ID en específico:

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/id 

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/id

Por ejemplo: http://localhost/TPE-WEB2-Parte3/api/prendas/54

‎------------

Endpoint DELETE para eliminar por un ID en específico: 

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/id 

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/id

Por ejemplo: http://localhost/TPE-WEB2-Parte3/api/detalles/55

‎------------

Endpoint POST para agregar una prenda o un detalle de una prenda (no es necesario agregar un id ya que al ser autoincremental lo hace automaticamente):

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/

    Por ejemplo:
    {
        "prenda": "Camiseta polo",
        "tipo": "Remera",
        "costo": 9200,
        "rebaja": 24
    }

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/

    {
        "talle": "XS",
        "stock": 95,
        "categoria": "remera",
        "id_prenda": 54
    }

‎------------

Endpoint PUT Para editar: 

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/id (solo se puede editar "costo" y "rebaja")

tabladetalle: http://localhost/TPE-WEB2-Parte3/api/detalles/id (solo se pued editar "talle" y "stock")

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/54

    Por ejemplo:
    {
        "costo": 9200,
        "rebaja": 24
    }

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/54

    Por ejemplo:
    {
        "talle": "XS",
        "stock": 95
    }

‎------------

Endpoint GET para ordenar de manera ascendente o descendente por cualquier campo.

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas?sortby=(ALGO)&order=(ASC O DESC)

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles?sortby=(ALGO)&order=(ASC O DESC)

    Por ejemplo:

    tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas?sortby=costo&order=DESC
    
    detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles?sortby=stock&order=ASC

‎------------

Endpoint GET para filtrar por costo o stock.

tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/filtro/costos?costo=NUMERO

detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/filtro/stocks?stock=NUMERO

- El filtro en tablaprendas se hace para saber el costo de qué prendas están por debajo del precio (número) indicado.
- El filtro en detallesprenda se hace para saber cuáles stocks están por debajo del número indicado.

    Por ejemplo:
    
    tablaprendas: http://localhost/TPE-WEB2-Parte3/api/prendas/filtro/costos?costo=5000
  
    detallesprenda: http://localhost/TPE-WEB2-Parte3/api/detalles/filtro/stocks?stock=50
