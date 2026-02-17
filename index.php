<?php
// index.php - Simple PHP REST API Demo

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Simple in-memory data store (for demo purposes)
$users = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
    ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
    ['id' => 4, 'name' => 'Deepan', 'email' => 'deepansre@example.com']
];

// Route handler
switch ($path) {
    case '/':
    case '/api':
        handleRoot();
        break;
    case '/api/users':
        handleUsers($method, $users);
        break;
    case (preg_match('/\/api\/users\/(\d+)/', $path, $matches) ? true : false):
        handleUserById($method, $users, (int)$matches[1]);
        break;
    case '/api/health':
        handleHealth();
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
}

function handleRoot() {
    echo json_encode([
        'message' => 'Welcome to PHP REST API Demo',
        'version' => '1.0.0',
        'endpoints' => [
            'GET /api/health' => 'Health check',
            'GET /api/users' => 'Get all users',
            'GET /api/users/{id}' => 'Get user by ID',
            'POST /api/users' => 'Create user (demo)',
            'PUT /api/users/{id}' => 'Update user (demo)',
            'DELETE /api/users/{id}' => 'Delete user (demo)'
        ]
    ]);
}

function handleHealth() {
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'php_version' => phpversion()
    ]);
}

function handleUsers($method, $users) {
    switch ($method) {
        case 'GET':
            echo json_encode([
                'success' => true,
                'count' => count($users),
                'data' => $users
            ]);
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            echo json_encode([
                'success' => true,
                'message' => 'User created (demo only)',
                'data' => $input
            ]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
}

function handleUserById($method, $users, $id) {
    $user = array_filter($users, fn($u) => $u['id'] === $id);
    $user = !empty($user) ? array_values($user)[0] : null;
    
    switch ($method) {
        case 'GET':
            if ($user) {
                echo json_encode([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
            break;
        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            echo json_encode([
                'success' => true,
                'message' => "User {$id} updated (demo only)",
                'data' => $input
            ]);
            break;
        case 'DELETE':
            echo json_encode([
                'success' => true,
                'message' => "User {$id} deleted (demo only)"
            ]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
}
?>
