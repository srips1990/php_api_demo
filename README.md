# PHP REST API Demo

A simple PHP REST API application for demonstration purposes.

## Build and Run

**Using Docker:**
```bash
docker build -t php-rest-api .
docker run -p 8080:80 php-rest-api
```

**Using Docker Compose:**
```bash
docker-compose up -d
```

## API Endpoints

- `GET /api/health` - Health check
- `GET /api/users` - Get all users
- `GET /api/users/{id}` - Get user by ID
- `POST /api/users` - Create user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

## Test the API

```bash
# Health check
curl http://localhost:8080/api/health

# Get all users
curl http://localhost:8080/api/users

# Get user by ID
curl http://localhost:8080/api/users/1

# Create user (demo)
curl -X POST http://localhost:8080/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"New User","email":"new@example.com"}'
```
