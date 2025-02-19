# Project Setup

Follow these steps to set up and run the project locally.

## Steps to Setup

### 1. Build the Docker Containers
```bash
make build-dev
```

### 2. Database Migrations
```bash
make migrate
```

### 3. Load Development Fixtures
```bash
make load-fixtures-dev
```

### 4. Access the API Documentation
Open http://localhost:8200/api/doc in your browser.

## Ideas for Improvements
- For better performance, create a DailyStats table that stores precomputed counts of events per day. This will reduce the load on the Event table, especially when handling large numbers of events (e.g., 100K+ per day).
- Add repository method to retrieve all events at once.
- Define consistent frontend error codes.
- Complete unit tests (current tests require new test database setup, it was just added to show it as example)
- Implement git hooks.
- Apply PHP PSR-12 standards.
- Run `phpcs --fix` to ensure clean code.
- Introduce versioning (e.g., v1, v2, v3).
- Integrate OpenAPI on the frontend to streamline backend service usage.
- add production environment and deploy it by using CI/CD

#### Note
- the generate mercure keys (in .env) could be generated using Symfony command in the production for example
- i did use the poll request rather than real time, but i did implement it to show it as example