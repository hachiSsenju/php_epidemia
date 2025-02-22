<?php
namespace App;
require __DIR__ . '../../bootstrap.php';
$id = intval($_POST['id']);
$point=$entityManager->getRepository(Point::class)->find($id);

$entityManager->remove($point);
$entityManager->flush();
header('location: gestionPoint.php');