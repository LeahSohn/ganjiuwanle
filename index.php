<?php
// index.php - Chinese pledge site (minimal, self-hosted)
// This file handles showing the form and displaying a confirmation page.

// Basic POST detection
$isSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

// Helper: sanitize output
function e($v) {
	return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>
<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>干就完了</title>
	<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<main class="container">
	<?php if (!$isSubmitted): ?>
		<header class="hero">
			<h1>干就完了</h1>
			<p class="tagline">别废话了。干就完了。</p>
			<div class="domain"><a href="https://ganjiuwanle.com" target="_blank" rel="noopener">ganjiuwanle.com</a></div>
		</header>

		<form id="pledgeForm" method="POST" action="" class="card">
			<label>目标（必须完成的事）
				<input type="text" name="goal" required maxlength="200" placeholder="例如：每天写 1000 字" />
			</label>

			<label>截止日期
				<input type="date" name="deadline" required />
			</label>

			<label>失败要付多少钱（人民币）
				<select name="amount" required>
					<option value="50">¥50</option>
					<option value="100">¥100</option>
					<option value="200">¥200</option>
					<option value="500">¥500</option>
					<option value="1000">¥1000</option>
				</select>
			</label>

			<label>监督人邮箱（可选）
				<input type="email" name="supervisor_email" placeholder="监督人邮箱（可空）" />
			</label>

			<label>你的邮箱（可选）
				<input type="email" name="user_email" placeholder="你的邮箱（可空）" />
			</label>

			<div class="actions">
				<button type="submit" class="btn primary">我他妈答应了</button>
				<button type="button" class="btn" id="saveLocal">保存到本地</button>
			</div>
		</form>

		<section class="notes">
			<h3>使用说明</h3>
			<ul>
				<li>填写目标并确认。页面会显示你的承诺，方便截图或分享给监督人。</li>
				<li>此演示不包含支付流程；要接入支付请使用 Stripe/支付宝等服务。</li>
				<li>你可以使用“保存到本地”按钮将承诺保存在浏览器。</li>
			</ul>
		</section>

	<?php else: ?>
		<?php
		// Sanitize posted values
		$goal            = e($_POST['goal'] ?? '');
		$deadline        = e($_POST['deadline'] ?? '');
		$amount          = e($_POST['amount'] ?? '');
		$supervisorEmail = e($_POST['supervisor_email'] ?? '（未填写）');
		$userEmail       = e($_POST['user_email'] ?? '（未填写）');
		// Create a shareable text
		$shareText = "我承诺：{$goal}，截止：{$deadline}，失败需付：¥{$amount}。去他妈的，去做！";
		?>

		<article class="card">
			<h2>已记录你的承诺</h2>
			<p><strong>目标：</strong> <?= $goal ?></p>
			<p><strong>截止日期：</strong> <?= $deadline ?></p>
			<p><strong>失败要付：</strong> ¥<?= $amount ?></p>
			<p><strong>监督人：</strong> <?= $supervisorEmail ?></p>
			<p><strong>你的邮箱：</strong> <?= $userEmail ?></p>

			<div class="actions">
				<button id="copyBtn" class="btn primary" data-text="<?= e($shareText) ?>">复制承诺文本</button>
				<button id="printBtn" class="btn">打印 / 截图</button>
				<a href="/" class="btn">再立一个目标</a>
			</div>

			<p class="hint">提示：把此页面截图发给监督人，或把信息写进你的日历。</p>
		</article>

	<?php endif; ?>
</main>

<script src="/assets/js/main.js"></script>
</body>
</html>

