<?php
declare(strict_types=1);
session_start();
$cfg = require __DIR__.'/config.php';
try {
  $pdo = new PDO("mysql:host={$cfg['db_host']};dbname={$cfg['db_name']};charset=utf8mb4", $cfg['db_user'], $cfg['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
} catch (Throwable $e) { http_response_code(500); exit('Banco de dados não configurado. Edite config.php com a senha MySQL correta.'); }
function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function me(): ?array { global $pdo; if(empty($_SESSION['arena_user'])) return null; $s=$pdo->prepare('SELECT * FROM users WHERE id=? AND status="active"'); $s->execute([$_SESSION['arena_user']]); return $s->fetch() ?: null; }
function require_login(): array { $u=me(); if(!$u){ header('Location: login.php'); exit; } return $u; }
function require_admin(): array { $u=require_login(); if(!in_array($u['role'],['superadmin','publisher_admin','editor'],true)){ http_response_code(403); exit('Acesso restrito.'); } return $u; }
function require_client(): array { $u=require_login(); if($u['role'] !== 'member'){ header('Location: admin.php'); exit; } return $u; }
function is_developer(array $u): bool { global $cfg; $emails=array_map('strtolower',(array)($cfg['developer_emails']??[])); return in_array(strtolower((string)$u['email']),$emails,true); }
function require_developer(): array { $u=require_login(); if(!is_developer($u)){ http_response_code(403); exit('Acesso restrito ao desenvolvedor.'); } return $u; }
function flash(string $key, ?string $value=null): ?string { if($value!==null){ $_SESSION['flash'][$key]=$value; return null; } $r=$_SESSION['flash'][$key]??null; unset($_SESSION['flash'][$key]); return $r; }
function default_publisher(): int { global $pdo; $q=$pdo->query("SELECT id FROM publishers ORDER BY id LIMIT 1"); $id=$q->fetchColumn(); if($id) return (int)$id; $pdo->prepare('INSERT INTO publishers(name,slug,email) VALUES(?,?,?)')->execute(['Arena Studios','arena-studios','contato@arenadeaco.com.br']); return (int)$pdo->lastInsertId(); }
function user_plan(int $userId): string { global $pdo; $q=$pdo->prepare("SELECT p.code FROM subscriptions s JOIN plans p ON p.id=s.plan_id WHERE s.user_id=? AND s.status IN ('trial','active') ORDER BY s.id DESC LIMIT 1"); $q->execute([$userId]); return $q->fetchColumn() ?: 'basic'; }
function is_ultimate(int $id): bool { return user_plan($id)==='ultimate'; }
function nav(?array $u): void { ?>
<header class="topbar"><a href="index.php" class="brand">⚔ <span>ARENA</span> DE AÇO</a><nav><a href="index.php#catalogo">Mangás</a><a href="index.php#planos">Planos</a><?php if($u): ?><a href="client_documents.php">PDFs</a><a href="community.php">Comunidade</a><a href="support.php">Suporte</a><?php if(is_developer($u)):?><a href="developer.php">Dev</a><?php endif;?><?php endif; ?></nav><div><?php if($u): ?><a class="link" href="<?=in_array($u['role'],['superadmin','publisher_admin','editor'],true)?'admin.php':'conta.php'?>">Painel</a><a class="btn mini" href="logout.php">Sair</a><?php else: ?><a class="link" href="login.php">Entrar</a><a class="btn mini" href="cadastro.php">Assinar agora</a><?php endif; ?></div></header><?php }
