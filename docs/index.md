# Php Access GUDID api Consumer Documentation

## Installation

1. [Install the library](#1-install)
2. [Usage](#2-usage)
3. [Endpoints](#3-endpoint)
4. [Device Identifier Type](#4-device-identifier-type)
5. [Final note](#5-final-note)

### 1. Install

Run from terminal:

```bash
> composer require medicalmundi/php-access-gudid-consumer
```

### 2. Usage

```php

$GudidConsumer = new AccessGudidConsumer();

$jsonResponse = $GudidConsumer->parseUdi('(01)00208851107345(17)150331');

```

### 3. Endpoint

This library maps the three usecase exposed by the AccessGUDID api.

```php
$GudidConsumer->parseUdi('=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123');

// second parameters is the Identifier type
$GudidConsumer->devicesLookup('=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123', DeviceIdentifierType::fullUniqueDeviceIdentifier());

// second parameters is the Identifier type
$GudidConsumer->devicesHistory('=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123', DeviceIdentifierType::fullUniqueDeviceIdentifier());
```

### 4. Device Identifier Type

AccessGUDID api endpoints (lookup and history) requires the identifier type
parameter in query string.

Allowed type:

| php | description |
|:--- |:----------- |
| DeviceIdentifierType::deviceIdentifier() | The Device Identifier string unique to a specific device |
| DeviceIdentifierType::fullUniqueDeviceIdentifier() | The full Unique Device Identifier string for a device |
| DeviceIdentifierType::publicRecordKey() | The unique Public Device Record Key string for a device |

```php
// call with a device identifier code
$GudidConsumer->devicesLookup('08717648200274', DeviceIdentifierType::deviceIdentifier());

// call with an udi code
$GudidConsumer->devicesLookup('=/08717648200274=,000025=A99971312345600=>014032=}013032&,1000000000000XYZ123', DeviceIdentifierType::fullUniqueDeviceIdentifier());

// call with public record key code
$GudidConsumer->devicesLookup('f18845df-38a8-4fc2-8d26-5cce28c8b868', DeviceIdentifierType::publicRecordKey());
```

### 5. Final note

At the moment this library only support json responses,
xml will be supported in next releases.
