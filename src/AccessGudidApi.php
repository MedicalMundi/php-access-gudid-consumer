<?php

declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

class AccessGudidApi
{
    public const HOST = 'accessgudid.nlm.nih.gov';

    public const API_VERSION = 'v2';

    public const ALLOWED_FORMAT = ['json' => 'json', 'xml' => 'xml'];

    public const RESOURCE_PARSE_UDI = 'parse_udi';

    public const RESOURCE_DEVICE_LIST = 'devices/implantable/list';

    public const RESOURCE_DEVICE_LOOKUP = 'devices/lookup';

    public const RESOURCE_DEVICES_HISTORY = 'devices/history';
}
