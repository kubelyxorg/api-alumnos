<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=127.0.0.1;dbname=api_alumnos', '<setYourUser>', '<setYourPass>'));

Flight::route('GET /alumnos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();

    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::route('POST /alumnos', function () {
    $nombres = (Flight::request()->data->nombres);
    $apellidos = (Flight::request()->data->apellidos);

    $sql = "INSERT INTO alumnos (nombres,apellidos) VALUES(?,?)";
    $sentencia = Flight::db()->prepare($sql);

    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);

    $sentencia->execute();

    Flight::jsonp(["Alumno agregado"]);
});

Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);

    $sql = "DELETE FROM alumnos WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);

    $sentencia->execute();

    Flight::jsonp(["Alumno eliminado"]);

});

Flight::route('PUT /alumnos', function () {
    $id = (Flight::request()->data->id);
    $nombres = (Flight::request()->data->nombres);
    $apellidos = (Flight::request()->data->apellidos);

    $sql = "UPDATE alumnos SET nombres=?, apellidos=? WHERE id=?";
    $sentencia = Flight::db()->prepare($sql);

    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->bindParam(3, $id);

    $sentencia->execute();

    Flight::jsonp(["Alumno actualizado"]);

});

Flight::route('GET /alumnos/@id', function ($id) {
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id=?");
    $sentencia->bindParam(1, $id);
    $sentencia->execute();

    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

Flight::start();
