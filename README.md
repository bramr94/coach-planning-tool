# LiveWall Assessment - Coach planning tool

## Installation

1. Clone the project.
2. Run composer install.

```
composer install
```

3. Copy the .env.example file.

```
cp .env.example .env
```

4. Add database credentials to the `.env ` file.
5. For local development you can run the `DevelopmentSeeder`.
   1. A test user will be created.
      1. Email: dev@test.com
      2. Password: password
   3. 10 coaches will be created with faker data.

```
php artisan db:seed --class=DevelopmentSeeder
```

## Pint

We've installed Laravel Pint to help with code style. Currently, we use the default Laravel preset.

```
vendor/bin/pint
```

## PHPStan

Current PHPStan level: 7

Run PHPStan:

```
vendor/bin/phpstan
```

## Tests

Create a table named: `livewall_assessment_test`. This can be changed in the .env file.

Run all tests:

```
vendor/bin/phpunit
```

## Endpoints

Postman collection: [LiveWall Assessment.postman_collection.json](LiveWall assessment.postman_collection.json)

### API config

You can make changes to the API configuration in the `config/api.php` file.

**Pagination**

By default, responses are paginated with 5 items per page.

### Login

`http://www.example.com/api/login`

**Form data**

- Email: dev@test.com
- Password: password

**Response**

```json
{
    "token": "bearer-token"
}
```

You need to be authenticated to use the rest of the API, the token must be included in the Authorization header as a Bearer token.

### Logout

`http://www.example.com/api/logout`

**Response**

```json
{
    "message": "Logged out"
}
```

### Retrieve authenticated user

`http://www.example.com/api/me`

**Response**

```json
{
    "data": {
        "id": 1,
        "name": "Development user",
        "email": "dev@test.com",
        "appointments": [
            {
                "id": 1,
                "date": "2024-06-24T00:00:00.000000Z",
                "coach": {
                    "id": 1,
                    "name": "Maiya Boehm",
                    "email": "boehm.delta@example.net",
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                "start_time": "08:30:00",
                "end_time": "09:30:00",
                "created_at": "2024-06-24T08:02:21.000000Z",
                "updated_at": "2024-06-24T08:02:21.000000Z"
            },
            {
                "id": 2,
                "date": "2024-06-24T00:00:00.000000Z",
                "coach": {
                    "id": 1,
                    "name": "Maiya Boehm",
                    "email": "boehm.delta@example.net",
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                "start_time": "09:45:00",
                "end_time": "10:30:00",
                "created_at": "2024-06-24T08:16:23.000000Z",
                "updated_at": "2024-06-24T08:16:23.000000Z"
            }
        ],
        "created_at": "2024-06-24T08:00:34.000000Z",
        "updated_at": "2024-06-24T08:00:34.000000Z"
    }
}
```

### Retrieve coaches

`http://www.example.com/api/coaches`

By default, the current week is used to show the schedule of the coaches. If you want to change this you can
include a `start_date` and `end_date` to view a different week.

**Form data (optional)**

- start_date: 2024-06-17
- end_date: 2024-06-23

**Response**

By default, the response will be paginated with 5 items per page. To keep this readme short the example will only show one record.

```json
{
    "data": [
        {
            "id": 1,
            "name": "Maiya Boehm",
            "email": "boehm.delta@example.net",
            "schedule": [
                {
                    "id": 1,
                    "coach_id": 1,
                    "day": 1,
                    "day_name": "Monday",
                    "start_time": "08:30:00",
                    "end_time": "17:00:00",
                    "is_available": true,
                    "appointments": [
                        {
                            "id": 1,
                            "date": "2024-06-24T00:00:00.000000Z",
                            "start_time": "08:30:00",
                            "end_time": "09:30:00",
                            "created_at": "2024-06-24T08:02:21.000000Z",
                            "updated_at": "2024-06-24T08:02:21.000000Z"
                        }
                    ],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 2,
                    "coach_id": 1,
                    "day": 2,
                    "day_name": "Tuesday",
                    "start_time": "08:30:00",
                    "end_time": "17:00:00",
                    "is_available": true,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 3,
                    "coach_id": 1,
                    "day": 3,
                    "day_name": "Wednesday",
                    "start_time": "08:30:00",
                    "end_time": "17:00:00",
                    "is_available": true,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 4,
                    "coach_id": 1,
                    "day": 4,
                    "day_name": "Thursday",
                    "start_time": "08:30:00",
                    "end_time": "17:00:00",
                    "is_available": true,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 5,
                    "coach_id": 1,
                    "day": 5,
                    "day_name": "Friday",
                    "start_time": "08:30:00",
                    "end_time": "17:00:00",
                    "is_available": true,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 6,
                    "coach_id": 1,
                    "day": 6,
                    "day_name": "Saturday",
                    "start_time": null,
                    "end_time": null,
                    "is_available": false,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                },
                {
                    "id": 7,
                    "coach_id": 1,
                    "day": 0,
                    "day_name": "Sunday",
                    "start_time": null,
                    "end_time": null,
                    "is_available": false,
                    "appointments": [],
                    "created_at": "2024-06-24T08:00:34.000000Z",
                    "updated_at": "2024-06-24T08:00:34.000000Z"
                }
            ],
            "created_at": "2024-06-24T08:00:34.000000Z",
            "updated_at": "2024-06-24T08:00:34.000000Z"
        }
    ],
    "links": {
        "first": "http://livewall-assessment.test/api/coaches?page=1",
        "last": "http://livewall-assessment.test/api/coaches?page=10",
        "prev": null,
        "next": "http://livewall-assessment.test/api/coaches?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=3",
                "label": "3",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=4",
                "label": "4",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=5",
                "label": "5",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=6",
                "label": "6",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=7",
                "label": "7",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=8",
                "label": "8",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=9",
                "label": "9",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=10",
                "label": "10",
                "active": false
            },
            {
                "url": "http://livewall-assessment.test/api/coaches?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://livewall-assessment.test/api/coaches",
        "per_page": 1,
        "to": 1,
        "total": 10
    }
}
```

### Retrieve a specific coach

`http://www.example.com/api/coaches/{coach_id}`

By default, the current week is used to show the schedule of the coaches. If you want to change this you can
include a `start_date` and `end_date` to view a different week.

**Form data (optional)**

- start_date: 2024-06-17
- end_date: 2024-06-23

**Response**

```json
{
    "data": {
        "id": 1,
        "name": "Maiya Boehm",
        "email": "boehm.delta@example.net",
        "schedule": [
            {
                "id": 1,
                "coach_id": 1,
                "day": 1,
                "day_name": "Monday",
                "start_time": "08:30:00",
                "end_time": "17:00:00",
                "is_available": true,
                "appointments": [
                    {
                        "id": 1,
                        "date": "2024-06-24T00:00:00.000000Z",
                        "start_time": "08:30:00",
                        "end_time": "09:30:00",
                        "created_at": "2024-06-24T08:02:21.000000Z",
                        "updated_at": "2024-06-24T08:02:21.000000Z"
                    }
                ],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 2,
                "coach_id": 1,
                "day": 2,
                "day_name": "Tuesday",
                "start_time": "08:30:00",
                "end_time": "17:00:00",
                "is_available": true,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 3,
                "coach_id": 1,
                "day": 3,
                "day_name": "Wednesday",
                "start_time": "08:30:00",
                "end_time": "17:00:00",
                "is_available": true,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 4,
                "coach_id": 1,
                "day": 4,
                "day_name": "Thursday",
                "start_time": "08:30:00",
                "end_time": "17:00:00",
                "is_available": true,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 5,
                "coach_id": 1,
                "day": 5,
                "day_name": "Friday",
                "start_time": "08:30:00",
                "end_time": "17:00:00",
                "is_available": true,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 6,
                "coach_id": 1,
                "day": 6,
                "day_name": "Saturday",
                "start_time": null,
                "end_time": null,
                "is_available": false,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            },
            {
                "id": 7,
                "coach_id": 1,
                "day": 0,
                "day_name": "Sunday",
                "start_time": null,
                "end_time": null,
                "is_available": false,
                "appointments": [],
                "created_at": "2024-06-24T08:00:34.000000Z",
                "updated_at": "2024-06-24T08:00:34.000000Z"
            }
        ],
        "created_at": "2024-06-24T08:00:34.000000Z",
        "updated_at": "2024-06-24T08:00:34.000000Z"
    }
}
```

### Schedule a appointment

`http://www.example.com/api/appointments`

**Form data**

- coach_id: 1
- date: 2024-06-24
- start_time: 08:30:00
- end_time: 09:00:00

Coaches must be available on the given date, and cannot have any appointments planned on the given date.

Validation error when the coach is not available on the given date.

```json
{
    "message": "The coach is not available on the given date or time.",
    "errors": {
        "coach_id": [
            "The coach is not available on the given date or time."
        ]
    }
}
```

Validation error when the coach already has an appointment on the given time.

```json
{
    "message": "The coach is not available at the given time.",
    "errors": {
        "coach_id": [
            "The coach is not available at the given time."
        ]
    }
}
```

**Response**

An email will be sent to the user and the coach confirming the appointment.

```json
{
    "data": {
        "id": 2,
        "date": "2024-06-24T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "Development user",
            "email": "dev@test.com",
            "created_at": "2024-06-24T08:00:34.000000Z",
            "updated_at": "2024-06-24T08:00:34.000000Z"
        },
        "coach": {
            "id": 1,
            "name": "Maiya Boehm",
            "email": "boehm.delta@example.net",
            "created_at": "2024-06-24T08:00:34.000000Z",
            "updated_at": "2024-06-24T08:00:34.000000Z"
        },
        "start_time": "09:45:00",
        "end_time": "10:30:00",
        "created_at": "2024-06-24T08:16:23.000000Z",
        "updated_at": "2024-06-24T08:16:23.000000Z"
    }
}
```
