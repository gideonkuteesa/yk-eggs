<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$rows = $pdo->query("SELECT * FROM calculations ORDER BY id DESC")->fetchAll();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>YK Eggs | History</title><link rel="stylesheet" href="assets/style.css"></head>
<body><div class="app"><header class="topbar"><div class="brand"><div class="logo">YK</div><div><strong>YK EGGS</strong><span>Wholesale & Retail</span></div></div><nav><a href="index.php">Dashboard</a><a class="active" href="history.php">History</a></nav></header>
<main class="container"><section class="hero"><div><h1>Calculation History</h1><p>Every saved egg-profit calculation in one place.</p></div><a class="btn" href="index.php">+ New calculation</a></section>
<section class="panel"><div class="table-wrap"><table><thead><tr><th>Date</th><th>Trays</th><th>Buy</th><th>Sell</th><th>Breakage</th><th>Sales</th><th>Cost</th><th>Net profit</th><th>Margin</th></tr></thead><tbody>
<?php if(!$rows): ?><tr><td colspan="9" class="muted">No history yet.</td></tr><?php endif; ?>
<?php foreach($rows as $r): ?><tr><td><?= e($r['created_at']) ?></td><td><?= number_format($r['trays_purchased']) ?></td><td><?= money($r['buying_price']) ?></td><td><?= money($r['selling_price']) ?></td><td><?= number_format($r['breakage_pct'],2) ?>%</td><td><?= money($r['total_sales']) ?></td><td><?= money($r['total_cost']) ?></td><td class="<?= $r['net_profit']<0?'loss':'positive' ?>">UGX <?= money($r['net_profit']) ?></td><td><?= number_format($r['profit_margin'],2) ?>%</td></tr><?php endforeach; ?>
</tbody></table></div></section></main><footer>YK Eggs Profit Calculator</footer></div></body></html>