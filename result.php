<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM calculations WHERE id=?");
$stmt->execute([$id]);
$r = $stmt->fetch();
if (!$r) { header('Location: index.php'); exit; }
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>YK Eggs | Result</title><link rel="stylesheet" href="assets/style.css"></head>
<body><div class="app"><header class="topbar"><div class="brand"><div class="logo">YK</div><div><strong>YK EGGS</strong><span>Wholesale & Retail</span></div></div><nav><a href="index.php">Dashboard</a><a href="history.php">History</a></nav></header>
<main class="container narrow"><section class="panel report"><div class="report-title"><div><h1>Profit Result</h1><p><?= e($r['note'] ?: 'Egg trading calculation') ?></p></div><button class="btn secondary" onclick="window.print()">Print</button></div>
<div class="result-main <?= $r['net_profit'] < 0 ? 'negative':'positive' ?>"><span>Net Profit</span><strong>UGX <?= money($r['net_profit']) ?></strong></div>
<div class="metrics">
<div><span>Trays purchased</span><b><?= number_format($r['trays_purchased']) ?></b></div>
<div><span>Sellable trays</span><b><?= number_format($r['sellable_trays'],2) ?></b></div>
<div><span>Total sales</span><b>UGX <?= money($r['total_sales']) ?></b></div>
<div><span>Total cost</span><b>UGX <?= money($r['total_cost']) ?></b></div>
<div><span>Break-even / sellable tray</span><b>UGX <?= money($r['break_even_price']) ?></b></div>
<div><span>Profit margin</span><b><?= number_format($r['profit_margin'],2) ?>%</b></div>
</div>
<h3>Calculation inputs</h3><div class="table-wrap"><table><tr><th>Buying price / tray</th><td>UGX <?= money($r['buying_price']) ?></td></tr><tr><th>Selling price / tray</th><td>UGX <?= money($r['selling_price']) ?></td></tr><tr><th>Breakage</th><td><?= number_format($r['breakage_pct'],2) ?>% (<?= number_format($r['broken_trays'],2) ?> trays)</td></tr><tr><th>Transport</th><td>UGX <?= money($r['transport']) ?></td></tr><tr><th>Loading / offloading</th><td>UGX <?= money($r['loading']) ?></td></tr><tr><th>Other expenses</th><td>UGX <?= money($r['other_expenses']) ?></td></tr></table></div>
<div class="actions"><a class="btn" href="index.php">New calculation</a><a class="btn secondary" href="history.php">View history</a></div>
</section></main><footer>YK Eggs Profit Calculator</footer></div></body></html>