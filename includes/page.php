<?php
require_once __DIR__.'/bootstrap.php';
$allowed = ['home','locator','guide','materials','products','feedback','faqs'];
if (!in_array($currentPage, $allowed, true)) { http_response_code(404); exit; }
$reports = $currentPage === 'feedback' ? load_reports() : [];
$titles = ['home'=>'Living Soil Network','locator'=>'Gujarat Composting Facilities','guide'=>'6-Phase Complete Field Guide','materials'=>'Materials Matrix','products'=>'Curated Composting Equipment','feedback'=>'Community Reviews & Field Reports','faqs'=>'Frequently Asked Questions'];
$version = '20261015-'.substr(hash('sha256', hash_file('sha256', __DIR__.'/../assets/css/style.css').hash_file('sha256', __DIR__.'/../assets/js/app.js')),0,8);
header('Cache-Control: no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');
$payload = ['page'=>$currentPage,'centers'=>$centers,'cityPresets'=>$content['GUJARAT_CITY_COORDINATES'],'mapKey'=>require __DIR__.'/../config/map.php'];
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($titles[$currentPage]) ?> | EarthCycle Gujarat</title>
<meta name="description" content="Gujarat composting guides, materials matrix, eco hardware, community reports and the original Google Maps facility locator.">
<link rel="icon" href="assets/images/logo.svg" type="image/svg+xml">
<link rel="stylesheet" href="assets/css/style.css?v=<?= e($version) ?>">
</head>
<body>
<div id="site" class="min-h-screen bg-[#02130c] text-slate-100 flex flex-col font-sans selection:bg-emerald-500/30 selection:text-emerald-200">
<div id="gmpQuotaBanner" hidden class="bg-amber-950/80 border-b border-amber-600/40 text-amber-200 px-4 py-2.5 text-xs text-center sticky top-0 z-50 backdrop-blur-md">Google Maps Platform quota reached. If you are the app owner, visit <a href="https://developers.google.com/maps/ai/ai-studio?utm_campaign=gmp_mcp_codeassist_v1_aistudio#quota_exceeded_errors" target="_blank" rel="noopener noreferrer" class="underline font-bold text-amber-300">maps developer site</a> for instructions.</div>
<?php include __DIR__.'/background.php'; include __DIR__.'/nav-'.$currentPage.'.php'; ?>
<main class="flex-1"><?php include __DIR__.'/../views/'.$currentPage.'.php'; ?></main>
<?php include __DIR__.'/footer.php'; ?>
</div>
<script>window.EARTHCYCLE=<?= json_encode($payload, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_SLASHES) ?>;</script>
<script type="module" src="assets/js/app.js?v=<?= e($version) ?>"></script>
</body>
</html>
