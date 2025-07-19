<?php
require_once __DIR__ . '/../../src/config/init.php';
require_once __DIR__ . '/../../src/controllers/ClientController.php';

$controller = new ClientController();
$controller->valider_reservation();
