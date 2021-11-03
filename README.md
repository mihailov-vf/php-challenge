# php-challenge

## Visão geral
Este projeto tem como objetivo aplicar boas praticas de desenvolvimento em aplicações PHP com fins de utilização escalável e alto desempenho

## Requisitos e detalhes da aplicação

**Funcionalidades**
 - [ ] Autenticação API
 - [ ] Importação de arquivos para
---------
**Técnicas**
 - [x] SOLID
 - [x] DDD
 - [ ] Event-Driven
 - [x] Clean Architecture
---------
**Ambiente**
 - [ ] Docker(Dev, Prod: "A completar")
 - [x] PHP 8
 - [ ] RoadRunner Server
 - [x] Slim Micro-Framework
 - [x] PostgreSQL
 - [ ] Armazenamento de arquivos AWS S3 (s3-ninja para ambiente local)
 - [ ] Filas e mensageria com RabbitMQ
 - [ ] Autenticação e autorização com Keyclock
---------
**Ferramentas**
 - [ ] JWT Token
 - [x] Persistência agnóstica (Implementação inicial de repositórios com Doctrine DBAL)
 - [x] Migrations (Doctrine)
 - [x] Análise de código: PHPCS, PHPStan
 - [x] Testes Unitários, Integração e Funcionais: PHPUnit
 - [ ] Documentação API: swagger-php
---------

## Inicialização
Execute os comandos


```
docker-compose up -d
docker-compose exec app .docker/run/prepare.sh
```


A API estará disponível através da porta 8000, com os seguintes caminhos disponíveis:
- GET   http://localhost:8000/ - [WIP] Documentação da API(Swagger)
- POST  http://localhost:8000/api/users/ - Criação de usuários
- POST  http://localhost:8000/api/import/ - [WIP] Importação CSV
- GET   http://localhost:8000/api/import/{ID} - [WIP] Status da importação
