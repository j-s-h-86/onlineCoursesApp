<?php
require_once '../../vendor/autoload.php';
require_once '../../config/secret.php';
require_once '../../config/database.php';
require_once '../../models/Order.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);

header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);

if (!isset($inputData['price'])) {
  echo json_encode(['error' => 'Price not provided']);
  http_response_code(400);
  exit;
}

$fullName = $inputData['fullName'];
$email = $inputData['email'];
$courseId = $inputData['courseId'];
$price = $inputData['price'];

$YOUR_DOMAIN = 'http://localhost:5173';

try {
  $priceObject = \Stripe\Price::create([
    'unit_amount' => $price * 100,
    'currency' => 'sek',
    'product_data' => [
      'name' => "Course ID: $courseId",
    ],
  ]);

  $checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [
      [
        'price' => $priceObject->id,
        'quantity' => 1,
      ]
    ],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success',
    'cancel_url' => $YOUR_DOMAIN . '/cancelled-payment',
  ]);

  $order = new Order($pdo);

  $orderData = [
    'fullName' => $fullName,
    'email' => $email,
    'courseId' => $courseId,
    'price' => $price
  ];
  $order->createOrder($orderData);

  echo json_encode(['id' => $checkout_session->id]);

} catch (\Stripe\Exception\ApiErrorException $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
?>