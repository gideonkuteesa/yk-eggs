<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }

$trays = max(1, (int)($_POST['trays'] ?? 0));
$buy = max(0, (float)($_POST['buying_price'] ?? 0));
$sell = max(0, (float)($_POST['selling_price'] ?? 0));
$breakage = min(100, max(0, (float)($_POST['breakage_pct'] ?? 0)));
$transport = max(0, (float)($_POST['transport'] ?? 0));
$loading = max(0, (float)($_POST['loading'] ?? 0));
$other = max(0, (float)($_POST['other_expenses'] ?? 0));
$note = trim($_POST['note'] ?? '');

$v = calculateValues($trays,$buy,$sell,$breakage,$transport,$loading,$other);

$stmt = $pdo->prepare("INSERT INTO calculations
(trays_purchased,buying_price,selling_price,breakage_pct,broken_trays,sellable_trays,transport,loading,other_expenses,purchase_cost,total_sales,total_cost,net_profit,break_even_price,profit_margin,note)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->execute([$trays,$buy,$sell,$breakage,$v['broken'],$v['sellable'],$transport,$loading,$other,$v['purchase'],$v['sales'],$v['cost'],$v['profit'],$v['breakEven'],$v['margin'],$note]);

$id = $pdo->lastInsertId();
header("Location: result.php?id=" . urlencode($id));
exit;