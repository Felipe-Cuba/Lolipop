# Script PowerShell para gerenciar o projeto Lolipop com Docker
# Uso: .\docker-manager.ps1 [start|stop|restart|logs|status|clean]

param(
  [Parameter(Mandatory = $true)]
  [ValidateSet("start", "stop", "restart", "logs", "status", "clean", "build", "db-shell", "web-shell")]
  [string]$Command,
    
  [Parameter(Mandatory = $false)]
  [string]$Service
)

switch ($Command) {
  "start" {
    Write-Host "Iniciando containers do Lolipop..." -ForegroundColor Green
    docker-compose up -d
    Write-Host "Containers iniciados! Acesse:" -ForegroundColor Green
    Write-Host "  - Site: http://localhost:8080" -ForegroundColor Cyan
    Write-Host "  - phpMyAdmin: http://localhost:8081" -ForegroundColor Cyan
  }
  "stop" {
    Write-Host "Parando containers do Lolipop..." -ForegroundColor Yellow
    docker-compose down
  }
  "restart" {
    Write-Host "Reiniciando containers do Lolipop..." -ForegroundColor Yellow
    docker-compose down
    docker-compose up -d
  }
  "logs" {
    if ([string]::IsNullOrEmpty($Service)) {
      Write-Host "Logs de todos os serviços:" -ForegroundColor Blue
      docker-compose logs -f
    }
    else {
      Write-Host "Logs do servico $Service" -ForegroundColor Blue
      docker-compose logs -f $Service
    }
  }
  "status" {
    Write-Host "Status dos containers:" -ForegroundColor Blue
    docker-compose ps
  }
  "clean" {
    Write-Host "Removendo containers, volumes e imagens..." -ForegroundColor Red
    docker-compose down -v --rmi all
  }
  "build" {
    Write-Host "Reconstruindo containers..." -ForegroundColor Yellow
    docker-compose build --no-cache
    docker-compose up -d
  }
  "db-shell" {
    Write-Host "Acessando shell do MySQL..." -ForegroundColor Blue
    docker exec -it lolipop_db mysql -u lolipop_user -plolipop_pass lolipop
  }
  "web-shell" {
    Write-Host "Acessando shell do container web..." -ForegroundColor Blue
    docker exec -it lolipop_web bash
  }
}

# Exemplo de uso no final do script
if ($Command -eq "start") {
  Write-Host ""
  Write-Host "Exemplos de uso:" -ForegroundColor Gray
  Write-Host "  .\docker-manager.ps1 stop       # Para os containers" -ForegroundColor Gray
  Write-Host "  .\docker-manager.ps1 logs web   # Logs do container web" -ForegroundColor Gray
  Write-Host "  .\docker-manager.ps1 status     # Status dos containers" -ForegroundColor Gray
}
