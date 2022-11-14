
## Ejemplos basicos:
 hay valores por defecto para la consulta. El que el consumidor de la api puede editar, ya sea sort, order, limit u offset, se pueden usar y combinar de la forma que desee.

# GET- http://localhost/TPE2/api/bikes   
coleccion entera de motos 200 OK


# GET- http://localhost/TPE2/api/bikes/2 
traer moto con id especifico si no existe , trae 404 not found


# GET- http://localhost/TPE2/api/bikes?order=DESC 
ordena por defecto, motos en precio , valores posibles = ASC o DESC 


# GET- http://localhost/TPE2/api/bikes?sort=nombre 
ordena por cualquier campo(columna) de la tabla sino, 400 bad request.


# GET- http://localhost/TPE2/api/bikes?sort=nombre&order=DESC 
combina ambos, trae campo(columna) y ademas ordena de forma ascendente o descendente


# POST- http://localhost/TPE2/api/bikes 
completar el json con los datos, inserta a la tabla el nuevo item, verifica que se le pasen todos los campos(columnas),si estan, se inserta con 201 Created,  sino no inserta retornando un  400 Bad Request.
{
        "nombre": "POSTMAN MOTO",
        "imagen": "images/imgTemp/634cbbb8dbbf4.jpg",
        "descripcion": "Moto agregada por postman",
        "cilindrada": 450,
        "precio": 12399,
        "id_marca_fk": 7
    }
    

# GET- http://localhost/TPE2/api/bikes?limit=1&sort=nombre&order=desc
ejemplo mostrando mas parametros combinados, en el caso que la columna no exista, o el order no sea ASC o DESC, o el limit no sea un numero entero positivo, va a dar error.

# GET- http://localhost/TPE2/api/bikes?filtervalue=350
trae todas las motos con cilindrada, de tipo 250 340 y 450 , lo demas es incorrecto.

# DELETE- http://localhost/TPE2/api/bikes/12
borra la moto con el id dado, sino existe devuelve que no existe la moto con ese id 404 Not found.