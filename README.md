# Lolipop - Sistema de Receitas

Este é um sistema web de receitas culinárias desenvolvido em PHP com MySQL.

## 🐳 Executando com Docker

### Pré-requisitos

- Docker
- Docker Compose

### Instruções de Instalação

1. **Clone o repositório** (se ainda não tiver):

   ```bash
   git clone <url-do-repositorio>
   cd lolipop
   ```

2. **Configure as variáveis de ambiente**:

   - O arquivo `.env` já está configurado com valores padrão
   - Você pode modificar as credenciais se necessário

3. **Execute o projeto**:

   ```bash
   docker-compose up -d
   ```

4. **Acesse a aplicação**:
   - **Site principal**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081
     - Usuário: `lolipop_user`
     - Senha: `lolipop_pass`

### Comandos Úteis

**Usando o script de gerenciamento (PowerShell - Windows)**:

```powershell
.\docker-manager.ps1 start     # Inicia os containers
.\docker-manager.ps1 stop      # Para os containers
.\docker-manager.ps1 restart   # Reinicia os containers
.\docker-manager.ps1 status    # Status dos containers
.\docker-manager.ps1 logs      # Logs de todos os serviços
.\docker-manager.ps1 logs web  # Logs apenas do container web
```

**Usando o script de gerenciamento (Bash - Linux/Mac)**:

```bash
./docker-manager.sh start      # Inicia os containers
./docker-manager.sh stop       # Para os containers
./docker-manager.sh status     # Status dos containers
```

**Comandos Docker Compose diretos**:

**Parar os containers**:

```bash
docker-compose down
```

**Visualizar logs**:

```bash
docker-compose logs web
docker-compose logs db
```

**Reconstruir containers**:

```bash
docker-compose down
docker-compose up --build -d
```

**Acessar terminal do container web**:

```bash
docker exec -it lolipop_web bash
```

**Acessar MySQL diretamente**:

```bash
docker exec -it lolipop_db mysql -u lolipop_user -p lolipop
```

### Estrutura dos Serviços

- **web**: Servidor Apache com PHP 7.4 (porta 8080)
- **db**: MySQL 8.0 (porta 3307)
- **phpmyadmin**: Interface web para gerenciar o banco (porta 8081)

### Banco de Dados

O banco de dados é automaticamente criado e populado com a estrutura inicial quando os containers são iniciados pela primeira vez.

### Volumes

- **Código fonte**: Mapeado como volume para desenvolvimento
- **Dados do MySQL**: Persistidos em volume Docker
- **Uploads**: Diretório para arquivos enviados

### Configurações de Desenvolvimento

Para desenvolvimento, os arquivos são mapeados como volumes, então você pode editar o código e ver as mudanças imediatamente sem reconstruir os containers.

## 🔧 Solução de Problemas

**Erro de conexão com banco de dados**:

- Verifique se o container do MySQL está rodando: `docker-compose ps`
- Aguarde alguns segundos para o MySQL inicializar completamente

**Porta já em uso**:

- Mude as portas no `docker-compose.yml` se necessário

**Permissões de arquivo**:

- Execute: `docker exec -it lolipop_web chown -R www-data:www-data /var/www/html`
