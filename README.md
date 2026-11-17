# Arena de Aço SaaS

<p align="center">
  <strong>Plataforma premium para mangás, capítulos, vídeos exclusivos e comunidade por assinatura.</strong>
</p>

<p align="center">
  <a href="https://github.com/AdrianoBuenoCruz/SaaS-arena-de-Aco-">Repositório</a> ·
  <a href="#instalação">Instalação</a> ·
  <a href="#segurança">Segurança</a> ·
  <a href="#operação">Operação</a>
</p>

---

## Sobre o projeto

O Arena de Aço é um SaaS desenvolvido para oferecer uma experiência premium de leitura e entretenimento, com planos recorrentes, catálogo de mangás, capítulos protegidos, vídeos exclusivos, comunidade, suporte ao assinante e painel administrativo.

A plataforma foi preparada para hospedagem PHP/MySQL, especialmente em ambiente cPanel/HostGator, com integração preparada para Asaas, PWA e autenticação por passkeys/WebAuthn.

## Principais recursos

### Área pública

- Landing page com identidade visual anime;
- Catálogo e apresentação dos planos;
- Página responsiva para desktop e celular;
- PWA instalável em dispositivos compatíveis;
- Navegação com HTTPS e sessão segura.

### Área do cliente

- Cadastro e login;
- Assinatura vinculada ao plano contratado;
- Biblioteca de capítulos e documentos;
- Visualização protegida de PDFs;
- Vídeos exclusivos por plano;
- Comunidade com mensagens;
- Tickets de suporte;
- Conta, notificações e passkeys;
- Login por digital, Face ID ou bloqueio do dispositivo, quando suportado.

### Painel administrativo

- Dashboard administrativo;
- Gestão de usuários e assinantes;
- Cadastro e edição de planos e preços;
- Cadastro de mangás e capítulos;
- Publicação de vídeos MP4/WebM ou links do YouTube;
- Publicação de PDFs e documentos;
- Controle de conteúdo por plano;
- Atendimento de tickets;
- Moderação da comunidade;
- Controle de status e permissões.

### Área restrita do desenvolvedor

A área técnica é separada do painel do cliente e fica disponível somente para o responsável autorizado. Ela permite acompanhar:

- Versão do PHP;
- Status do banco;
- Permissões de diretórios;
- Saúde básica do ambiente;
- Atalhos de manutenção;
- Informações de configuração.

## Tecnologias

- PHP 8+
- MySQL/MariaDB
- PDO
- HTML5 e CSS3
- JavaScript
- PWA com Manifest e Service Worker
- WebAuthn/Passkeys
- Integração Asaas
- Apache/.htaccess
- Hospedagem compatível com cPanel

## Estrutura principal

| Arquivo ou pasta | Função |
|---|---|
| `index.php` | Página inicial |
| `login.php` / `cadastro.php` | Autenticação |
| `admin.php` | Painel administrativo |
| `developer.php` | Área técnica restrita |
| `admin_plans.php` | Planos e preços |
| `admin_catalog.php` | Mangás e capítulos |
| `admin_document.php` | PDFs e documentos |
| `video_novo.php` | Vídeos e YouTube |
| `community.php` | Comunidade |
| `support.php` | Suporte do cliente |
| `database.sql` | Banco inicial |
| `upgrade.sql` | Atualização de banco existente |
| `config.example.php` | Modelo seguro de configuração |
| `manifest.json`, `sw.js`, `pwa.js` | PWA |
| `webauthn*.php` | Passkeys e biometria |

## Instalação

1. Faça o download ou clone este repositório.
2. Envie os arquivos para a raiz do domínio ou subdomínio.
3. Copie `config.example.php` para `config.php`.
4. Preencha os dados reais do banco, domínio e integrações.
5. Crie o banco e o usuário MySQL no cPanel.
6. Importe `database.sql` em uma instalação nova.
7. Em uma instalação já existente, importe somente `upgrade.sql`.
8. Ative o SSL e confirme o acesso por HTTPS.
9. Acesse `setup.php` uma única vez para criar o primeiro administrador.
10. Exclua `setup.php` imediatamente após concluir a configuração.
11. Teste cadastro, login, planos, conteúdo, suporte e comunidade.

## Configuração

Nunca publique credenciais reais no GitHub.

Exemplo de configuração:

```php
<?php
return [
  'db_host' => 'localhost',
  'db_name' => 'SEU_BANCO',
  'db_user' => 'SEU_USUARIO_MYSQL',
  'db_pass' => 'SUA_SENHA_MYSQL',
  'base_url' => 'https://SEU-DOMINIO',
  'asaas_token' => '',
  'asaas_sandbox' => true,
  'asaas_webhook_secret' => '',
  'developer_emails' => ['SEU_EMAIL_DE_DESENVOLVEDOR'],
];
```

Para produção:

- Use `asaas_sandbox => false` somente após os testes;
- Configure o webhook no Asaas;
- Use um segredo exclusivo para o webhook;
- Mantenha o domínio com HTTPS;
- Não compartilhe o arquivo `config.php`.

## Banco de dados

O banco contém estruturas para:

- Usuários e perfis;
- Planos;
- Assinaturas;
- Mangás e capítulos;
- Vídeos;
- Documentos privados;
- Tickets e respostas;
- Comunidade;
- Notificações;
- Logs de auditoria;
- Credenciais WebAuthn.

O arquivo `upgrade.sql` utiliza tabelas condicionais e foi preparado para atualizar uma instalação existente sem apagar usuários, assinaturas ou conteúdos já cadastrados.

## Segurança

A aplicação utiliza:

- Controle de sessão;
- Separação entre cliente, administrador e desenvolvedor;
- Verificação de plano antes de liberar conteúdo;
- Diretório privado para documentos;
- Bloqueio de acesso direto aos PDFs;
- Marca d'água no conteúdo quando configurada;
- Proteção de arquivos por sessão;
- WebAuthn/Passkeys;
- HTTPS obrigatório para biometria;
- `.gitignore` para impedir o envio de credenciais;
- Configuração separada por ambiente.

Nenhum navegador consegue impedir totalmente uma captura feita pelo sistema operacional, por outro aparelho ou por ferramentas externas. A proteção aplicada reduz o acesso indevido e dificulta a redistribuição, mas não substitui política de uso, marca d'água e controle jurídico do conteúdo.

## Asaas

A integração está preparada para:

- Checkout;
- Assinaturas recorrentes;
- Ambiente sandbox;
- Webhook;
- Atualização de status da assinatura;
- Controle de acesso conforme plano.

Antes da produção, valide o fluxo completo no sandbox e confirme o webhook no painel do Asaas.

## Operação administrativa

O administrador deve:

1. Criar ou revisar os planos;
2. Conferir os preços;
3. Cadastrar mangás e capítulos;
4. Publicar vídeos e documentos;
5. Configurar os planos mínimos;
6. Testar uma conta de cliente;
7. Acompanhar tickets e comunidade;
8. Realizar backups do banco e dos conteúdos;
9. Verificar pagamentos e webhooks;
10. Remover o `setup.php` após a primeira configuração.

## Checklist de produção

- [ ] Domínio apontado corretamente;
- [ ] SSL ativo;
- [ ] Banco criado;
- [ ] Usuário MySQL vinculado ao banco;
- [ ] `config.php` configurado;
- [ ] Banco importado;
- [ ] Primeiro administrador criado;
- [ ] `setup.php` removido;
- [ ] Permissões revisadas;
- [ ] Asaas sandbox testado;
- [ ] Webhook configurado;
- [ ] Cadastro e login testados;
- [ ] Conteúdos protegidos testados;
- [ ] PWA testado no celular;
- [ ] Passkey/biometria testada;
- [ ] Backup inicial realizado.

## Documentação

O pacote documental completo, incluindo contrato SaaS, manuais, termos, LGPD, suporte, checklist e homologação, foi preparado separadamente para o lançamento comercial.

## Responsável

**Infotech Soluções em Sistemas**  
CNPJ: **64.095.344/0001-04**  
Responsável técnico: **Adriano Leolino Bueno Cruz**

## Licença e direitos

O código, a marca, as imagens, os mangás, os vídeos e os documentos devem ser utilizados conforme a titularidade ou licença correspondente. Conteúdos de terceiros não devem ser publicados sem autorização.

---

**Arena de Aço SaaS — documentação e código preparados para configuração, homologação e lançamento controlado.**
