<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
$secret=(string)($cfg['asaas_webhook_secret']??'');
$received=(string)($_SERVER['HTTP_ASAAS_ACCESS_TOKEN']??$_SERVER['HTTP_X_ASAAS_ACCESS_TOKEN']??'');
if($secret!=='' && !hash_equals($secret,$received)){http_response_code(401);exit;}
$body=json_decode(file_get_contents('php://input'),true)?:[];
$event=(string)($body['event']??'');$subscription=(string)($body['payment']['subscription']??$body['subscription']['id']??'');
$map=['PAYMENT_CONFIRMED'=>'active','PAYMENT_RECEIVED'=>'active','PAYMENT_OVERDUE'=>'overdue','PAYMENT_DELETED'=>'cancelled','SUBSCRIPTION_DELETED'=>'cancelled','SUBSCRIPTION_INACTIVE'=>'cancelled'];
if($subscription!=='' && isset($map[$event])){$pdo->prepare('UPDATE subscriptions SET status=?,updated_at=NOW() WHERE asaas_subscription_id=?')->execute([$map[$event],$subscription]);}
http_response_code(200);header('Content-Type: application/json');echo json_encode(['received'=>true]);
