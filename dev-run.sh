#!/bin/bash

# Caminho para o arquivo docker-compose do serviço
DEV_DOCKER_COMPOSE_PATH="docker/docker-compose-dev.yml"

# Comando sail
SAIL="./vendor/bin/sail"

# Verifica se o argumento foi fornecido
if [ $# -eq 0 ]; then
    echo "Argumento necessário: start | stop | restart"
    exit 1
fi

# Função para iniciar os serviços
start_services() {
    $SAIL -f $DEV_DOCKER_COMPOSE_PATH up -d
}

# Função para parar os serviços
stop_services() {
    $SAIL -f $DEV_DOCKER_COMPOSE_PATH down
}

# Função para reiniciar os serviços
restart_services() {
    stop_services
    start_services
}

# Tratamento de argumentos
case "$1" in
    start)
        start_services
        ;;
    stop)
        stop_services
        ;;
    restart)
        restart_services
        ;;
    *)
        echo "Argumento inválido: $1"
        echo "Uso: $0 {start|stop|restart}"
        exit 1
        ;;
esac
