<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$stats = getDashboardStats($pdo);
$recent = getRecentCalculations($pdo, 5);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>YK Eggs | Profit Calculator</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
<header class="topbar">
  <div class="brand"><div class="logo">YK</div><div><strong>YK EGGS</strong><span>Wholesale & Retail</span></div></div>
  <nav><a class="active" href="index.php">Dashboard</a><a href="history.php">History</a></nav>
</header>
<main class="container">
  <section class="hero">
    <div><h1>Egg Profit Calculator</h1><p>Know your real profit before you sell.</p></div>
    <div class="hero-badge">Version 1.0</div>
  </section>

  <section class="cards">
    <div class="card"><span>Total Calculations</span><b><?= number_format($stats['calculations']) ?></b></div>
    <div class="card"><span>Total Trays Calculated</span><b><?= number_format($stats['trays']) ?></b></div>
    <div class="card"><span>Total Profit Recorded</span><b>UGX <?= money($stats['profit']) ?></b></div>
    <div class="card"><span>Average Profit / Tray</span><b>UGX <?= money($stats['avg_profit']) ?></b></div>
  </section>

  <div class="grid">
    <section class="panel">
      <div class="panel-head"><h2>New Calculation</h2><span class="pill">UGX</span></div>
      <form id="profitForm" action="calculate.php" method="post">
        <div class="form-grid">
          <label>Trays purchased<input type="number" name="trays" id="trays" min="1" step="1" value="100" required></label>
          <label>Buying price / tray<input type="number" name="buying_price" id="buying_price" min="0" step="1" value="12000" required></label>
          <label>Selling price / tray<input type="number" name="selling_price" id="selling_price" min="0" step="1" value="14000" required></label>
          <label>Breakage %<input type="number" name="breakage_pct" id="breakage_pct" min="0" max="100" step="0.01" value="2"></label>
          <label>Transport<input type="number" name="transport" id="transport" min="0" step="1" value="50000"></label>
          <label>Loading / offloading<input type="number" name="loading" id="loading" min="0" step="1" value="10000"></label>
          <label>Other expenses<input type="number" name="other_expenses" id="other_expenses" min="0" step="1" value="0"></label>
          <label>Calculation note<input type="text" name="note" maxlength="255" placeholder="e.g. Kampala delivery"></label>
        </div>
        <div class="live-results">
          <div><span>Sellable trays</span><strong id="sellable">98</strong></div>
          <div><span>Total sales</span><strong id="sales">UGX 1,372,000</strong></div>
          <div><span>Total cost</span><strong id="cost">UGX 1,260,000</strong></div>
          <div class="profit-box"><span>Estimated net profit</span><strong id="profit">UGX 112,000</strong></div>
        </div>
        <button class="btn" type="submit">Calculate & Save</button>
      </form>
    </section>

    <aside class="panel explanation">
      <h2>How YK Eggs calculates profit</h2>
      <div class="formula">Net Profit = Sales − Total Costs</div>
      <ol>
        <li>Calculate egg purchase cost.</li>
        <li>Estimate breakages and sellable trays.</li>
        <li>Calculate sales from sellable trays.</li>
        <li>Add transport and other expenses.</li>
        <li>Subtract total costs from sales.</li>
      </ol>
      <div class="tip"><b>Tip:</b> Your break-even price is the minimum price per sellable tray needed to recover all costs.</div>
    </aside>
  </div>

  <section class="panel">
    <div class="panel-head"><h2>Recent calculations</h2><a href="history.php">View all →</a></div>
    <?php if (!$recent): ?><p class="muted">No calculations saved yet.</p><?php else: ?>
    <div class="table-wrap"><table><thead><tr><th>Date</th><th>Trays</th><th>Buy/tray</th><th>Sell/tray</th><th>Profit</th><th>Margin</th></tr></thead><tbody>
    <?php foreach($recent as $r): ?><tr>
      <td><?= e($r['created_at']) ?></td><td><?= number_format($r['trays_purchased']) ?></td>
      <td>UGX <?= money($r['buying_price']) ?></td><td>UGX <?= money($r['selling_price']) ?></td>
      <td class="<?= $r['net_profit'] < 0 ? 'loss':'positive' ?>">UGX <?= money($r['net_profit']) ?></td>
      <td><?= number_format($r['profit_margin'],2) ?>%</td>
    </tr><?php endforeach; ?>
    </tbody></table></div><?php endif; ?>
  </section>
</main>
<footer>YK Eggs Profit Calculator • Local business tool</footer>
</div>
<script src="assets/app.js"></script>
</body>
</html>