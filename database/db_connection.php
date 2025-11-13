<?php

function connectDatabase()
{
        $dsn = 'sqlite:' . __DIR__ . '/database.sqlite';
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'CREATE TABLE IF NOT EXISTS cameras(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        date DATE NOT NULL,
        price REAL NOT NULL,
        type TEXT NOT NULL
    );';

        $pdo->exec($query);

        $query = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    )";

        $pdo->exec($query);

        return $pdo;
}
?>