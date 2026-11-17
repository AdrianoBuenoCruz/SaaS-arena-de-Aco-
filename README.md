# Arena de Aço — SaaS pronto para lançamento

## Instalação
1. No cPanel, envie **todos os arquivos desta pasta** para a raiz do subdomínio `arena.infotechsolucoessistemas.com.br`.
2. Edite `config.php` e informe a senha MySQL do usuário `adri3428_arenausr`.
3. Importe `database.sql` no banco `adri3428_arena` pelo phpMyAdmin. Se o banco já possui dados, importe somente `upgrade.sql`.
4. Abra `setup.php` uma única vez para criar o superadministrador e depois exclua `setup.php`.
5. Permissões: pastas `755`, arquivos `644`, `uploads` e `private_docs` em `755`. Mantenha `private_docs/.htaccess` ativo.

## Asaas
Em `config.php`, insira o token em `asaas_token`. Mantenha `asaas_sandbox` como `true` para testes e altere para `false` somente com a chave de produção. A integração cria assinaturas recorrentes com período inicial de 7 dias. Cadastre no Asaas o webhook `https://SEU-DOMINIO/asaas_webhook.php` e use o mesmo segredo em `asaas_webhook_secret`.

## Conteúdo, comunidade e PDFs
O administrador publica vídeos MP4/WebM ou links do YouTube em `video_novo.php`, PDFs em `admin_document.php`, preços em `admin_plans.php`, capítulos em `admin_catalog.php` e modera o chat em `admin_chat.php`. O cliente vê a biblioteca em `client_documents.php`; os PDFs são entregues por sessão, plano, marca d'água e renderização sem toolbar de download/impressão. Nenhum navegador consegue impedir 100% uma captura feita pelo sistema operacional, mas o acesso direto ao arquivo fica bloqueado e a leitura é protegida.
Importe `upgrade.sql` uma vez no banco já existente. Ele usa `CREATE TABLE IF NOT EXISTS` e não apaga usuários, assinaturas ou conteúdo. A comunidade fica disponível em `community.php` e o chat atualiza automaticamente a cada poucos segundos.

## PWA e segurança
O `manifest.json`, `sw.js` e `pwa.js` deixam a área instalável como PWA quando o domínio está em HTTPS. Após concluir, remova `setup.php`. Vídeos e PDFs são bloqueados pela aplicação para usuários sem plano; para proteção avançada de streaming em produção, use armazenamento privado/CDN.

## Área do desenvolvedor e biometria
O primeiro administrador criado pelo `setup.php` recebe automaticamente o acesso exclusivo a `developer.php`. Essa área mostra saúde do sistema, versão PHP, banco, permissões e atalhos de manutenção. O login por biometria usa passkeys/WebAuthn: o usuário ativa a passkey dentro de `conta.php` e depois pode entrar pela tela de login usando digital, Face ID ou o bloqueio do celular. HTTPS é obrigatório; a tabela correspondente está incluída no `upgrade.sql`.
