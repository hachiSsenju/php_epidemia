<?php
namespace App;
require __DIR__ . '../../bootstrap.php';
$id = intval($_POST['id']);
$pays=$entityManager->getRepository(Pays::class)->find($id);

$entityManager->remove($pays);
$entityManager->flush();
header('location: gestionPays.php');