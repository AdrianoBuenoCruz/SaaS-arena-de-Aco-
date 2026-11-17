# Arena de Aço — publicação no Git

Este repositório contém o código da plataforma SaaS, banco inicial, atualização
de banco, PWA, comunidade, suporte, painel administrativo, área restrita do
desenvolvedor, PDFs protegidos, vídeos, integração Asaas e passkeys/WebAuthn.

## Segurança

- `config.php` não deve ser versionado.
- Use `config.example.php` como modelo.
- Nunca publique senha MySQL, token Asaas ou segredo de webhook.
- Remova `setup.php` do servidor depois de criar o primeiro administrador.
- Mantenha HTTPS ativo para PWA, biometria e cookies seguros.

## Responsável

Infotech Soluções em Sistemas — CNPJ 64.095.344/0001-04

Responsável técnico: Adriano Leolino Bueno Cruz.
