<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Requirements
* PHP 8.2
* Composer
* Laravel 12
* Laravel Sanctum

# API Documentation

AUTH LOGIN AND REGISTRATION

### REGISTRATION

Register User

Endpoint: /register
Method: POST
Description: Registers a new user with the system.

Request Body

Content-Type: application/json

| Field              | Type   | Required | Description                                               |
| ------------------ | ------ | -------- | --------------------------------------------------------- |
| `name`             | string | Yes      | Full name of the user.                                    |
| `email`            | string | Yes      | User’s email address (must be unique).                    |
| `password`         | string | Yes      | User’s password (should meet your security requirements). |
| `confirm_password` | string | Yes      | Confirmation of the password, must match `password`.      |

Example Request
```
{
    "name": "Nicky",
    "email": "sample@gmail.com",
    "password": "Samplesample!23",
    "confirm_password": "Samplesample!23"
}

```

Response
Success (201 Created or 200 OK):
```
{
    "message": "Registered Successfully."
}
```

Error Responses:
```
{
    "message": "The name has already been taken. (and 2 more errors)",
    "errors": {
        "name": [
            "The name has already been taken."
        ],
        "email": [
            "The email has already been taken."
        ],
        "confirm_password": [
            "The confirm password field must match password."
        ]
    }
}
```

### LOGIN

Login User

Endpoint: /login
Method: POST
Description: Authenticates a user and returns a session token along with user and role details.

Request Body

Content-Type: application/json
| Field      | Type   | Required | Description                      |
| ---------- | ------ | -------- | -------------------------------- |
| `email`    | string | Yes      | User’s registered email address. |
| `password` | string | Yes      | User’s password.                 |

Example Request:
```
{
    "email": "admin@admin.com",
    "password": "AdminAdmin!23"
}
```

Response
Success (200 OK):
```
{
    "success": "29|mIxpXFqiKH1NBizpcNJ9JUMhEhROPKSSF3uXRPXB9cc5f277",
    "user": {
        "id": 6,
        "name": "Administrator",
        "email": "admin@admin.com",
        "email_verified_at": null,
        "created_at": "2025-08-20T11:31:18.000000Z",
        "updated_at": "2025-08-20T11:31:18.000000Z",
        "role_id": 1,
        "role": {
            "id": 1,
            "name": "Admin",
            "created_at": "2025-08-20T09:48:48.000000Z",
            "updated_at": "2025-08-20T09:48:48.000000Z"
        }
    },
    "role": {
        "id": 1,
        "name": "Admin",
        "created_at": "2025-08-20T09:48:48.000000Z",
        "updated_at": "2025-08-20T09:48:48.000000Z"
    },
    "is_password_weak": false
}
```

Error Responses
```
{
    "error": "Invalid login credentials."
}
```

### TASK (FETCH)

Fetch Tasks

Endpoint: /task/fetch
Method: GET or POST
Description: Retrieves a list of tasks with optional filters for keyword, status, and priority. Supports pagination using take and skip.

Request Body (for POST) / Query Parameters (for GET)
| Field      | Type    | Required | Description                                              |
| ---------- | ------- | -------- | -------------------------------------------------------- |
| `keyword`  | string  | No       | Search for tasks by **title**. Partial matches allowed.  |
| `status`   | string  | No       | Filter tasks by status: `"pending"` or `"completed"`.    |
| `priority` | string  | No       | Filter tasks by priority: `"low"`, `"medium"`, `"high"`. |
| `take`     | integer | No       | Number of tasks to return. Default is 10.                |
| `skip`     | integer | No       | Number of tasks to skip for pagination. Default is 0.    |

Example Request (POST):
```
{
    "keyword": "",
    "status": "",
    "priority": "",
    "take": 10,
    "skip": 0
}
```

Response
Success (200 OK):
```
{
    "data": [
        {
            "id": 1,
            "title": "sample title",
            "description": "sample descriptions",
            "status": "pending",
            "priority": "low",
            "order": 1,
            "user_id": 1,
            "created_at": "2025-08-21T00:05:30.000000Z",
            "updated_at": "2025-08-21T00:05:30.000000Z"
        },
        // ... more tasks
    ]
}
```
### TASK (STORE)

Create Task

Endpoint: /task/store
Method: POST
Description: Creates a new task in the system. All fields are required.

Request Body

Content-Type: application/json
| Field         | Type   | Required | Description                                                          |
| ------------- | ------ | -------- | -------------------------------------------------------------------- |
| `title`       | string | Yes      | Title of the task.                                                   |
| `description` | string | Yes      | Detailed description of the task.                                    |
| `status`      | string | Yes      | Status of the task. Allowed values: `"pending"`, `"completed"`.      |
| `priority`    | string | Yes      | Priority of the task. Allowed values: `"low"`, `"medium"`, `"high"`. |
| `order`       | string | Yes      | Order number for sorting tasks.                                      |

Example Request:
```
{
    "title": "Sample Title",
    "description": "Sample Description",
    "status": "pending",
    "priority": "low",
    "order": "1"
}
```

Response
Success (201 Created):
```
{
    "data": {
        "title": "Sample Title",
        "description": "Sample Description",
        "status": "pending",
        "priority": "low",
        "order": "1",
        "user_id": 2,
        "updated_at": "2025-08-20T09:42:43.000000Z",
        "created_at": "2025-08-20T09:42:43.000000Z",
        "id": 1
    }
}
```

### TASK (UPDATE)

Update Task

Endpoint: /task/update/{id}
Method: PATCH
Description: Updates an existing task by its ID. All fields can be updated.

Path Parameter
| Parameter | Type    | Required | Description               |
| --------- | ------- | -------- | ------------------------- |
| `id`      | integer | Yes      | ID of the task to update. |

Request Body

Content-Type: application/json
| Field         | Type   | Required | Description                                      |
| ------------- | ------ | -------- | ------------------------------------------------ |
| `title`       | string | Yes      | Updated title of the task.                       |
| `description` | string | Yes      | Updated description of the task.                 |
| `status`      | string | Yes      | Updated status: `"pending"` or `"completed"`.    |
| `priority`    | string | Yes      | Updated priority: `"low"`, `"medium"`, `"high"`. |
| `order`       | string | Yes      | Updated order number for sorting tasks.          |

Example Request:
```
{
    "title": "Sample Title",
    "description": "Sample Description",
    "status": "completed",
    "priority": "low",
    "order": "1"
}
```

Response
Success (200 OK):
```
{
    "task": {
        "id": 1,
        "title": "Sample Title",
        "description": "Sample Description",
        "status": "completed",
        "priority": "low",
        "order": "1",
        "user_id": 2,
        "created_at": "2025-08-20T09:02:05.000000Z",
        "updated_at": "2025-08-20T09:07:49.000000Z"
    }
}
```

### TASK (DELETE)

Delete Task

Endpoint: /task/delete/{id}
Method: DELETE
Description: Deletes a task by its ID.

Path Parameter
| Parameter | Type    | Required | Description               |
| --------- | ------- | -------- | ------------------------- |
| `id`      | integer | Yes      | ID of the task to delete. |

Request Body
No request body is needed. The task ID is provided in the URL path.

Response
Success (200 OK):
```
{
    "message": "Task deleted successfully."
}
```

### USER (FETCH)

Fetch Users

Endpoint: /user/fetch
Method: GET or POST
Description: Retrieves a list of users with optional filtering by keyword, status, or priority. Supports pagination with take and skip.

Request Body (for POST) / Query Parameters (for GET)
| Field      | Type    | Required | Description                                               |
| ---------- | ------- | -------- | --------------------------------------------------------- |
| `keyword`  | string  | No       | Search by user name or email (partial match).             |
| `status`   | string  | No       | Filter users by status (if applicable). Optional field.   |
| `priority` | string  | No       | Filter users by priority (if applicable). Optional field. |
| `take`     | integer | No       | Number of users to return. Default is 10.                 |
| `skip`     | integer | No       | Number of users to skip for pagination. Default is 0.     |

Example Request (POST):
```
{
    "keyword": "",
    "status": "",
    "priority": "",
    "take": 10,
    "skip": 0
}
```

Response
Success (200 OK):
```
{
    "data": [
        {
            "id": 1,
            "name": "Administrator",
            "email": "admin@admin.com",
            "email_verified_at": null,
            "created_at": "2025-08-20T11:31:18.000000Z",
            "updated_at": "2025-08-20T11:31:18.000000Z",
            "role_id": 1,
            "role": {
                "id": 1,
                "name": "Admin",
                "created_at": "2025-08-20T09:48:48.000000Z",
                "updated_at": "2025-08-20T09:48:48.000000Z"
            }
        }
    ]
}
```

### USER (UPDATE)

Update User

Endpoint: /user/update/{id}
Method: PATCH
Description: Updates an existing user’s information by their ID.

Path Parameter
| Parameter | Type    | Required | Description               |
| --------- | ------- | -------- | ------------------------- |
| `id`      | integer | Yes      | ID of the user to update. |

Request Body

Content-Type: application/json
| Field   | Type   | Required | Description                                        |
| ------- | ------ | -------- | -------------------------------------------------- |
| `name`  | string | Yes      | Updated full name of the user.                     |
| `email` | string | Yes      | Updated email address of the user. Must be unique. |

Example Request:
```
{
    "name": "Nicky",
    "email": "nicky@gmail.com"
}
```

Response
Success (200 OK):
```
{
    "user": {
        "id": 2,
        "name": "Nicky",
        "email": "nicky@gmail.com",
        "email_verified_at": null,
        "created_at": "2025-08-20T07:46:36.000000Z",
        "updated_at": "2025-08-21T00:35:15.000000Z",
        "role_id": 2
    }
}
```

### USER (DELETE)

Delete User

Endpoint: /user/delete/{id}
Method: DELETE
Description: Deletes a user by their ID.

Path Parameter
| Parameter | Type    | Required | Description               |
| --------- | ------- | -------- | ------------------------- |
| `id`      | integer | Yes      | ID of the user to delete. |

Request Body
No request body is required. The user ID is specified in the URL path.

Response
Success (200 OK):
```
{
    "message": "User deleted successfully."
}
```
