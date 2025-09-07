# Configuração Docker - Projeto Lolipop

## ✅ Arquivos Criados

### Arquivos Docker

- **Dockerfile**: Configuração da imagem PHP/Apache
- **docker-compose.yml**: Orquestração dos serviços
- **.env**: Variáveis de ambiente
- **.dockerignore**: Arquivos ignorados no build

### Scripts de Gerenciamento

- **docker-manager.ps1**: Script PowerShell para Windows
- **docker-manager.sh**: Script Bash para Linux/Mac

### Arquivos Modificados

- **assets/rotinas/connect.php**: Atualizado para usar variáveis de ambiente

## 🚀 Como Usar

### 1. Iniciar o Projeto

```bash
docker-compose up -d
```

### 2. Acessar Aplicação

- **Site**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

### 3. Credenciais do Banco

- **Usuário**: lolipop_user
- **Senha**: lolipop_pass
- **Banco**: lolipop

## 🔧 Configuração dos Serviços

### Web (PHP/Apache)

- **Porta**: 8080
- **PHP**: 7.4
- **Extensões**: mysqli, pdo, pdo_mysql, zip
- **Apache**: mod_rewrite habilitado

### Database (MySQL)

- **Porta**: 3307 (externa), 3306 (interna)
- **Versão**: MySQL 8.0
- **Inicialização**: Automática com lolipop.sql

### phpMyAdmin

- **Porta**: 8081
- **Versão**: 5.2

## 📁 Estrutura de Volumes

- **Código**: Mapeado para desenvolvimento em tempo real
- **Database**: Volume persistente para dados MySQL
- **Uploads**: Diretório para arquivos enviados

## 🛠️ Desenvolvimento

O projeto está configurado para desenvolvimento com hot-reload. Qualquer alteração nos arquivos PHP será refletida imediatamente sem necessidade de restart.

## 🔄 Comandos Úteis

```bash
# Ver status
docker-compose ps

# Ver logs
docker-compose logs -f web
docker-compose logs -f db

# Parar
docker-compose down

# Rebuild
docker-compose build --no-cache
docker-compose up -d

# Acessar containers
docker exec -it lolipop_web bash
docker exec -it lolipop_db mysql -u lolipop_user -plolipop_pass lolipop
```

## ✨ Funcionalidades Implementadas

- ✅ Containerização completa do projeto
- ✅ Banco de dados MySQL com inicialização automática
- ✅ phpMyAdmin para gerenciamento do banco
- ✅ Configuração PHP com todas as extensões necessárias
- ✅ Apache com mod_rewrite habilitado
- ✅ Volumes para desenvolvimento
- ✅ Variáveis de ambiente para configuração
- ✅ Scripts de gerenciamento automatizados

## 🌐 URLs de Acesso

- **Aplicação Principal**: http://localhost:8080
- **Login**: http://localhost:8080/Login.php
- **Cadastro**: http://localhost:8080/cadastro.php
- **phpMyAdmin**: http://localhost:8081

## 🎯 Próximos Passos

1. Testar todas as funcionalidades do sistema
2. Configurar backup automático do banco
3. Implementar SSL/HTTPS se necessário
4. Configurar logs centralizados
5. Implementar monitoring (opcional)
