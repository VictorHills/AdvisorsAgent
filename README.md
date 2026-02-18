# AdvisorsAgent

A full-stack web application for managing student applications to universities. Agents submit and track applications on behalf of students, while counselors oversee all applications and agents across the platform.

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+), JWT authentication (`tymon/jwt-auth`)
- **Frontend:** Vue 3 SPA, Vue Router, Tailwind CSS, Chart.js
- **Build Tool:** Vite
- **Database:** SQLite (default), MySQL/PostgreSQL supported
- **Queue:** Database driver

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm

### Quick Setup

```bash
composer run setup
```

This runs the full setup: installs PHP and Node dependencies, copies `.env`, generates app key, runs migrations, and builds frontend assets.

### Development

```bash
composer run dev
```

This starts all services concurrently:
- PHP development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Log viewer (`php artisan pail`)
- Vite dev server (`npm run dev`)

### Individual Commands

```bash
# Frontend
npm run dev              # Vite dev server with HMR
npm run build            # Production build

# Backend
php artisan serve        # PHP dev server
php artisan migrate      # Run database migrations
php artisan queue:listen # Process queued jobs

# Testing
composer run test        # Run full test suite
php artisan test         # Run tests directly
php artisan test --filter=TestName  # Run a single test
```

### Docker

```bash
docker-compose up -d
```

Services:
- **App (PHP 8.2)** - Laravel backend
- **Nginx** - Reverse proxy on port `8000`
- **Node** - Vite dev server on port `5173`
- **MySQL 8** - Database on port `3306`

## User Roles

| Role | Description |
|------|-------------|
| **Agent** | Registers students, creates and manages applications, views own dashboard stats |
| **Counselor** | Admin role - views all students, applications, and agents across the platform |

## API Endpoints

All API routes are prefixed with `/api`.

### Public

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/auth/login` | User login (returns JWT) |
| POST | `/auth/register` | Agent registration |
| POST | `/auth/otp` | Request OTP for password reset |
| POST | `/auth/verify-otp` | Verify OTP token |
| POST | `/auth/reset-password` | Reset password |
| GET | `/courses` | List courses |
| GET | `/schools` | List universities |
| GET | `/countries` | List countries |
| GET | `/bdm-officers` | List BDM officers |
| GET | `/application-status` | List application statuses |

### Agent (requires JWT + agent role)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/applications` | List agent's applications |
| POST | `/applications` | Create application |
| GET | `/applications/{id}` | View application |
| PUT | `/applications/{id}` | Update application |
| PATCH | `/applications/{id}` | Partial update application |
| DELETE | `/applications/{id}` | Delete application |
| GET | `/students` | List agent's students |
| POST | `/students` | Create student |
| GET | `/students/{id}` | View student with applications |
| PATCH | `/students/{id}` | Update student |
| GET | `/dashboard/stats` | Agent dashboard statistics |
| GET | `/dashboard/applications-trend` | Application trends |
| GET | `/dashboard/applications-status` | Status breakdown |
| GET | `/dashboard/monthly-applications` | Monthly application data |
| GET | `/dashboard/recent-activity` | Recent activity feed |

### Counselor (requires JWT + counselor role)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/applications` | All applications |
| GET | `/admin/applications/{id}` | View any application |
| PATCH | `/admin/applications/{id}` | Update application status |
| GET | `/admin/students` | All students |
| GET | `/admin/students/{id}` | View any student |
| GET | `/admin/agents` | All agents with stats |
| GET | `/admin/dashboard/stats` | Platform-wide statistics |
| GET | `/admin/dashboard/*` | Other dashboard endpoints |

### Pagination & Search

List endpoints support query parameters:
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 10)
- `search` - Search term (searches across relevant fields)
- Agents endpoint uses `term` instead of `search`

## Project Structure

```
app/
├── Http/
│   ├── Controllers/         # API controllers (agent + admin variants)
│   ├── Requests/            # Form request validation classes
│   ├── Resources/           # API resource transformers
│   └── Middleware/           # Auth & role-checking middleware
├── Models/                  # Eloquent models
├── Mail/                    # Mailable classes
└── Traits/                  # ApiResponses trait

resources/js/
├── pages/                   # Vue route components (Login, Dashboard, Applications, etc.)
├── components/              # Shared Vue components (Navigation, Charts)
├── services/api.js          # Centralized Axios API wrapper
├── composables/             # Reusable logic (useAuth, useTheme, useNetwork)
└── router/index.js          # Vue Router with auth guards

routes/api.php               # All API route definitions
```

## Environment Configuration

Copy `.env.example` to `.env` and configure as needed. Key variables:

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_CONNECTION` | `sqlite` | Database driver |
| `QUEUE_CONNECTION` | `database` | Queue driver |
| `MAIL_MAILER` | `log` | Mail driver (use `smtp` for production) |
| `JWT_SECRET` | - | Generated via `php artisan jwt:secret` |

## License

This project is proprietary software.
