# 📦 Backend - API de Contatos

API desenvolvida em **Laravel 12 + Sanctum + PostgreSQL** para gerenciar **contatos** e **endereços**, além de autenticação, recuperação de senha e integração com Google Maps e ViaCep.

---

## 🚀 Funcionalidades

- Autenticação e autorização com **Sanctum** (login, logout, registro, exclusão de conta).
- Recuperação de senha via e-mail (Gmail SMTP).
- Gerenciamento de **contatos** (CRUD completo).
- Integração com **ViaCep** e **Google Geocoding** para buscar endereço e coordenadas.
- Paginação, ordenação e filtros nos contatos.
- Middleware para proteger rotas autenticadas.
- Estrutura em camadas (Controllers, Services, DTOs, Requests, Models).

---

## ⚙️ Tecnologias

- **PHP 8.x**
- **Laravel 12**
- **PostgreSQL v17**
- **Sanctum**
- **Mail (SMTP Gmail)**
- **ViaCep API**
- **Google Geocoding API**

---

## 📂 Estrutura básica

- `app/`
- `DTO/`
- `External/ # Integrações externas (ViaCep, GoogleGeolocation)`
- `Http/`
- `Controllers/`
- `Requests/`
- `Models/`
- `Services/`
- `routes/`
- `api.php`


---

## 🔑 Rotas da API

### 🔐 Autenticação
| Método | Rota                    | Descrição                                 | Auth |
|--------|-------------------------|-------------------------------------------|------|
| POST   | /register               | Registro de novo usuário                  |  ❌  |
| POST   | /login                  | Login e obtenção de token                 |  ❌  |
| POST   | /logout                 | Logout e revogação do token               |  ✅  |
| DELETE | /user/delete            | Exclusão de conta (requer senha)          |  ✅  |

---

### 🔑 Recuperação de senha
| Método | Rota                    | Descrição                                 | Auth |
|--------|-------------------------|-------------------------------------------|------|
| POST   | /forgot-password        | Envia e-mail de recuperação               |  ❌  |
| POST   | /reset-password         | Redefine a senha usando token do e-mail   |  ❌  |

---

### 👤 Contatos
| Método | Rota                    | Descrição                                 | Auth |
|--------|-------------------------|-------------------------------------------|------|
| GET    | /contacts/list          | Lista contatos (com paginação e filtros)  |  ✅  |
| POST   | /contact/create         | Cria novo contato                         |  ✅  |
| PUT    | /contact/{id}/update    | Atualiza um contato                       |  ✅  |
| DELETE | /contact/{id}/delete    | Exclui um contato                         |  ✅  |

---

### 🌍 Endereços
| Método | Rota                    | Descrição                                 | Auth |
|--------|-------------------------|-------------------------------------------|------|
| GET    | /address/search         | Busca endereço (ViaCep + Geocoding)       |  ✅  |

---

## ⚡ Configurações necessárias
- Crie `.env` com base no `.env.example`
- Configure o banco, e-mail e API key do Google:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=contacts_db
DB_USERNAME=postgres
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seuemail@gmail.com
MAIL_PASSWORD=sua_senha_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seuemail@gmail.com
MAIL_FROM_NAME="Contacts API"

GOOGLE_GEOCODING_KEY=chave_google
```

▶️ Rodando o projeto

```bash
composer install
php artisan migrate
php artisan serve
```

A API estará em http://localhost:8000.

## 📮 Exemplos de payload

### Registro
```JSON
{
    "name": "Fulano",
    "email": "fulano@example.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

### Login
```JSON
{
    "email": "fulano@example.com",
    "password": "123456"
}
```
### Contato

```JSON
{
    "name": "Contato 1",
    "cpf": "12345678900",
    "phone": "11999999999",
    "address": "Rua Exemplo",
    "city": "São Paulo",
    "state": "SP",
    "latitude": "-23.55052",
    "longitude": "-46.633308"
}
```

## ✅ Testando

Use **Postman** ou **Insomnia** com o token de autenticação enviado no `Authorization: Bearer <token>`.