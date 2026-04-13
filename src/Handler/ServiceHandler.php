<?php

namespace App\Handler;

require_once __DIR__.'/../Database.php';
require_once __DIR__ . '/../Entity/Order.php';
require_once __DIR__ . '/../Entity/Status.php';

use App\Database;
use App\Entity\Order;
use App\Entity\Status;


$data = file_get_contents("php://input");
$data = json_decode($data, true);

$db = new Database();
$orders = new Order($db);
$statuses = new Status($db);
try {
    $order = $orders->changeStatus($data['order_id'], $data['status_id']);
} catch (\Throwable $th) {
    echo $th->getMessage();
}

echo json_encode([
    "order_id"=>$order,
    "message"=>"Статус заявки {$order} изменен на {$statuses->findStatus($data['status_id'])['name']}",
]);
?>