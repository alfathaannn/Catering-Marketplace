<?php
$content = file_get_contents('REFERENSI TEMPLATE/index.html');
preg_match('/<style>(.*?)<\/style>/s', $content, $css);
if (!file_exists('public/assets/css')) mkdir('public/assets/css', 0777, true);
file_put_contents('public/assets/css/merchant-dashboard.css', trim($css[1] ?? ''));

preg_match('/<script>(.*?)<\/script>/s', $content, $js);
if (!file_exists('public/assets/js')) mkdir('public/assets/js', 0777, true);
file_put_contents('public/assets/js/merchant-dashboard.js', trim($js[1] ?? ''));
echo "Extraction completed.";
