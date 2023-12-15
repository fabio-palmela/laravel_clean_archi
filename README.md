<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Padrões do Clean Architecture (Credicom)

### Estrutura de Pastas

#### `app` (Código Fonte)

##### `Adapters` (Adaptadores:  Formata entrada e saída de dados.)

##### `Application` (Camada de Aplicação)
- `UseCases` (Implementação dos Casos de Uso)
- ...

##### `Domain` (Núcleo da Aplicação - Domínio)
- `entities` (Entidades e Objetos de Valor)
- `repository` (Interfaces de Repositório)
- `service` (Interfaces de Serviço)
- ...

##### `Infra` (Adaptações Externas)
- `Adapters` (Conectores concretos - Eloquent, Doctrine, Banco de Dados, REST, etc.)
- `Config` (Configurações)
- ...

##### `Presentation` (Interfaces de Usuário / APIs)
- `Controllers` (Controladores para interação com o usuário ou APIs)
- `Dtos` (Data Transfer Objects)
- `Presenters` (Classes responsáveis por formatar a saída para as interfaces: Xml, Json, payload JSON, etc ...)
- `Views` (Componentes responsáveis pela apresentação visual, se aplicável)
- ...

#### `tests` (Testes para as Diferentes Camadas)
- `application`
- `domain`
- `infrastructure`
- ...



## Sobre o Clean Architecture

Clean Architecture é um conceito criado por Robert C. Martin com objetivo de criar sistemas de software com separação clara entre o modelo de negócio, os requisitos da aplicação, os modelos de dados e os drivers de comunicação externa da aplicação, tornando o código com o máximo de independência das tecnologias utilizadas e de fácil evolução/manutênção.

- [Blog do Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)