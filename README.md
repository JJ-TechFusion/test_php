# PHP REST API

A simple REST API built with vanilla PHP.

## Features

- `GET /health` - Health check endpoint
- `GET /items` - List all items
- `POST /items` - Create a new item
- `GET /items/{id}` - Get item by ID

## Setup

1. Install dependencies:
```bash
composer install
```

2. Run the server:
```bash
php -S localhost:8000
```

## Testing

```bash
composer test
```

## Deployment

Set the `PORT` environment variable and run:
```bash
php -S 0.0.0.0:$PORT
```

## Example Usage

```bash
# Health check
curl http://localhost:8000/health

# Create an item
curl -X POST http://localhost:8000/items \
  -H "Content-Type: application/json" \
  -d '{"name": "widget"}'

# List all items
curl http://localhost:8000/items

# Get item by ID
curl http://localhost:8000/items/1
```
