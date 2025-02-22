<?php
namespace App;
require __DIR__ . '../../bootstrap.php';
$id = intval($_POST['id']);
$zone=$entityManager->getRepository(Zone::class)->find($id);

$entityManager->remove($zone);
$entityManager->flush();
header('location: gestionZone.php');