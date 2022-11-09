GET- http://localhost/TPE2/api/bikes   
coleccion entera de motos 200 OK


GET- http://localhost/TPE2/api/bikes/2 
traer moto con id especifico si no existe , trae 404 not found


GET- http://localhost/TPE2/api/bikes?order=DESC 
ordena por defecto, motos en precio , ASC o DESC 


GET- http://localhost/TPE2/api/bikes?sort=nombre 
filtra por cualquier campo(columna) de la tabla.


GET- http://localhost/TPE2/api/bikes?sort=nombre?order=DESC 
combina ambos, filtra por campo(columna) y ademas ordena de forma ascendente o descendente


POST- http://localhost/TPE2/api/bikes 
completar el json con los datos, inserta a la tabla el nuevo item, verifica que se le pasen todos los campos(columnas),si estan, se inserta con 201 Created,  sino no inserta retornando un  400 Bad Request.


DELETE- http://localhost/TPE2/api/bikes/12
borra la moto con el id dado, sino existe devuelve 404 Not found.