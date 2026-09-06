<?php
function money($value) { return number_format((float)$value, 0); }
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }

function calculateValues($trays,$buy,$sell,$breakage,$transport,$loading,$other) {
    $broken = $trays * ($breakage / 100);
    $sellable = max(0, $trays - $broken);
    $purchase = $trays * $buy;
    $sales = $sellable * $sell;
    $cost = $purchase + $transport + $loading + $other;
    $profit = $sales - $cost;
    $breakEven = $sellable > 0 ? $cost / $sellable : 0;
    $margin = $sales > 0 ? ($profit / $sales) * 100 : 0;
    return compact('broken','sellable','purchase','sales','cost','profit','breakEven','margin');
}

function getDashboardStats($pdo) {
    $row = $pdo->query("SELECT COUNT(*) calculations, COALESCE(SUM(trays_purchased),0) trays, COALESCE(SUM(net_profit),0) profit FROM calculations")->fetch();
    $row['avg_profit'] = $row['trays'] > 0 ? $row['profit'] / $row['trays'] : 0;
    return $row;
}
function getRecentCalculations($pdo,$limit=5) {
    $limit = (int)$limit;
    return $pdo->query("SELECT * FROM calculations ORDER BY id DESC LIMIT $limit")->fetchAll();
}