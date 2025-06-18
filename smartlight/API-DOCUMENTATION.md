# API Documentation for SmartLight

## Base URL
The base URL for all API endpoints is:
`http://localhost/smartlight/public/api`

> **Note**: If you're using Laravel's built-in development server, the base URL would be:
> `http://localhost:8000/api`
>
> If you're using ngrok for ESP32 testing, replace with your ngrok URL:
> `https://your-ngrok-url.ngrok.io/api`

## Endpoints

### Light Status

#### Get Latest Light Status
- **URL:** `/light/status`
- **Method:** `GET`
- **Description:** Get the latest status of the smart light.
- **Response:**
```json
{
  "data": {
    "id": 1,
    "is_on": true,
    "ldr_value": 4095,
    "mode": "auto",
    "manual_override": false,
    "created_at": "2025-06-17T10:37:34.000000Z",
    "updated_at": "2025-06-17T10:37:34.000000Z"
  }
}
```

#### Update Light Status
- **URL:** `/light/status`
- **Method:** `POST`
- **Description:** Update the status of the smart light from the ESP32 device.
- **Request Body:**
```json
{
  "is_on": true,
  "ldr_value": 4095,
  "mode": "auto"
}
```
- **Response:**
```json
{
  "message": "Light status updated",
  "data": {
    "is_on": true,
    "ldr_value": 4095,
    "mode": "auto",
    "manual_override": false,
    "updated_at": "2025-06-17T10:37:34.000000Z",
    "created_at": "2025-06-17T10:37:34.000000Z",
    "id": 1
  }
}
```

#### Toggle Light
- **URL:** `/light/toggle`
- **Method:** `POST`
- **Description:** Toggle the light status (on/off).
- **Response:**
```json
{
  "message": "Light toggled",
  "data": {
    "is_on": false,
    "ldr_value": 4095,
    "mode": "manual",
    "manual_override": true,
    "updated_at": "2025-06-17T10:37:34.000000Z",
    "created_at": "2025-06-17T10:37:34.000000Z",
    "id": 2
  }
}
```

#### Get Light Status History
- **URL:** `/light/history`
- **Method:** `GET`
- **Description:** Get historical light status data for reporting.
- **Query Parameters:**
  - `period`: day, week, month (default: day)
  - `limit`: Number of records to return (default: 100)
- **Response:**
```json
{
  "data": [
    {
      "id": 120,
      "is_on": true,
      "ldr_value": 3200,
      "mode": "auto",
      "manual_override": false,
      "created_at": "2025-06-17T09:37:34.000000Z",
      "updated_at": "2025-06-17T09:37:34.000000Z"
    },
    {
      "id": 119,
      "is_on": true,
      "ldr_value": 3150,
      "mode": "auto",
      "manual_override": false,
      "created_at": "2025-06-17T09:32:34.000000Z",
      "updated_at": "2025-06-17T09:32:34.000000Z"
    }
  ],
  "meta": {
    "total": 120,
    "from": "2025-06-16T09:37:34.000000Z",
    "to": "2025-06-17T09:37:34.000000Z" 
  }
}
```

#### Set Operation Mode
- **URL:** `/light/mode`
- **Method:** `POST`
- **Description:** Set the operation mode of the smart light.
- **Request Body:**
```json
{
  "mode": "auto"
}
```
- **Response:**
```json
{
  "message": "Mode updated to auto",
  "data": {
    "is_on": true,
    "ldr_value": 4095,
    "mode": "auto",
    "manual_override": false,
    "updated_at": "2025-06-17T10:37:34.000000Z",
    "created_at": "2025-06-17T10:37:34.000000Z",
    "id": 3
  }
}
```

### Settings

#### Get All Settings
- **URL:** `/settings`
- **Method:** `GET`
- **Description:** Get all system settings.
- **Response:**
```json
{
  "data": [
    {
      "id": 1,
      "key": "ldr_threshold",
      "value": "500",
      "created_at": "2025-06-17T10:37:34.000000Z",
      "updated_at": "2025-06-17T10:37:34.000000Z"
    },
    {
      "id": 2,
      "key": "default_mode",
      "value": "auto",
      "created_at": "2025-06-17T10:37:34.000000Z",
      "updated_at": "2025-06-17T10:37:34.000000Z"
    }
  ]
}
```

### Schedules

#### Get Active Schedules
- **URL:** `/schedules`
- **Method:** `GET`
- **Description:** Get all active schedules.
- **Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Morning Light",
      "days": "1,2,3,4,5",
      "time": "07:00:00",
      "action": "turn_on",
      "action_value": true,
      "is_active": true,
      "created_at": "2025-06-17T10:37:34.000000Z",
      "updated_at": "2025-06-17T10:37:34.000000Z"
    },
    {
      "id": 2,
      "name": "Evening Off",
      "days": "1,2,3,4,5,6,7",
      "time": "22:30:00",
      "action": "turn_off",
      "action_value": false,
      "is_active": true,
      "created_at": "2025-06-17T10:37:34.000000Z",
      "updated_at": "2025-06-17T10:37:34.000000Z"
    }
  ]
}
```
