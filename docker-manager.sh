#!/bin/bash

# Script para gerenciar o projeto Lolipop com Docker
# Uso: ./docker-manager.sh [start|stop|restart|logs|status|clean]

case "$1" in
    start)
        echo "Iniciando containers do Lolipop..."
        docker-compose up -d
        echo "Containers iniciados! Acesse:"
        echo "  - Site: http://localhost:8080"
        echo "  - phpMyAdmin: http://localhost:8081"
        ;;
    stop)
        echo "Parando containers do Lolipop..."
        docker-compose down
        ;;
    restart)
        echo "Reiniciando containers do Lolipop..."
        docker-compose down
        docker-compose up -d
        ;;
    logs)
        if [ -z "$2" ]; then
            echo "Logs de todos os serviços:"
            docker-compose logs -f
        else
            echo "Logs do serviço $2:"
            docker-compose logs -f "$2"
        fi
        ;;
    status)
        echo "Status dos containers:"
        docker-compose ps
        ;;
    clean)
        echo "Removendo containers, volumes e imagens..."
        docker-compose down -v --rmi all
        ;;
    build)
        echo "Reconstruindo containers..."
        docker-compose build --no-cache
        docker-compose up -d
        ;;
    db-shell)
        echo "Acessando shell do MySQL..."
        docker exec -it lolipop_db mysql -u lolipop_user -plolipop_pass lolipop
        ;;
    web-shell)
        echo "Acessando shell do container web..."
        docker exec -it lolipop_web bash
        ;;
    *)
        echo "Uso: $0 {start|stop|restart|logs|status|clean|build|db-shell|web-shell}"
        echo ""
        echo "Comandos disponíveis:"
        echo "  start      - Inicia os containers"
        echo "  stop       - Para os containers"
        echo "  restart    - Reinicia os containers"
        echo "  logs       - Mostra logs (opcional: especificar serviço)"
        echo "  status     - Mostra status dos containers"
        echo "  clean      - Remove tudo (containers, volumes, imagens)"
        echo "  build      - Reconstrói as imagens"
        echo "  db-shell   - Acessa o shell do MySQL"
        echo "  web-shell  - Acessa o shell do container web"
        exit 1
        ;;
esac
