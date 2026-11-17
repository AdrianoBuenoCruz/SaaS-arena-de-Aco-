<?php
declare(strict_types=1);
$error='';$success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $host=trim($_POST['host']??'localhost');$db=trim($_POST['db']??'');$user=trim($_POST['user']??'');$pass=$_POST['pass']??'';$name=trim($_POST['name']??'');$email=strtolower(trim($_POST['email']??''));$adminPass=$_POST['admin_pass']??'';
  if(!$db||!$user||$pass===''||!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($adminPass)<10)$error='Confira todos os campos. A senha do administrador deve ter 10 ou mais caracteres.';
  else try{
    $pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $q=$pdo->prepare('SELECT id FROM users WHERE email=?');$q->execute([$email]);if($q->fetch())throw new RuntimeException('Já existe um usuário com este e-mail.');
    $pdo->prepare('INSERT INTO users(name,email,password_hash,role,status) VALUES(?,?,?,"superadmin","active")')->execute([$name,$email,password_hash($adminPass,PASSWORD_DEFAULT)]);
    $config="<?php\nreturn ".var_export(['db_host'=>$host,'db_name'=>$db,'db_user'=>$user,'db_pass'=>$pass,'base_url'=>'https://arena.infotechsolucoessistemas.com.br','asaas_token'=>'','asaas_sandbox'=>true,'asaas_webhook_secret'=>'','developer_emails'=>[$email]],true).";\n";
    if(file_put_contents(__DIR__.'/config.php',$config)===false)throw new RuntimeException('Não consegui gravar config.php. Altere a senha MySQL manualmente no arquivo.');
    $success='Superadministrador criado e acesso de desenvolvedor vinculado a este e-mail. Exclua setup.php agora.';
  }catch(Throwable $e){$error='Falha: '.$e->getMessage();}
}
?><!doctype html><html lang="pt-BR"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Configurar Arena</title><link rel="stylesheet" href="assets/app.css"><body class="auth"><main class="authbox"><a class="brand">⚔ ARENA DE AÇO</a><h1>Configuração inicial</h1><?php if($error):?><p class="alert err"><?=htmlspecialchars($error)?></p><?php endif?><?php if($success):?><p class="alert ok"><?=htmlspecialchars($success)?></p><?php else:?><form method="post"><label>Host<input name="host" value="localhost"></label><label>Banco MySQL<input name="db" placeholder="adri3428_arena" required></label><label>Usuário MySQL<input name="user" placeholder="adri3428_arenausr" required></label><label>Senha MySQL<input type="password" name="pass" required></label><hr><label>Nome administrador<input name="name" required></label><label>E-mail administrador<input type="email" name="email" required></label><label>Senha administrador<input type="password" minlength="10" name="admin_pass" required></label><button class="btn full">Concluir instalação →</button></form><?php endif?></main></body></html>
