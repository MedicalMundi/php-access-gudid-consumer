<?php


declare(strict_types=1);

namespace MedicalMundi\AccessGudid;

final class DeviceIdentifierType
{
    public const OPTIONS = [
        'PublicRecordKey' => 'record_key',
        'DeviceIdentifier' => 'di',
        'FullUniqueDeviceIdentifier' => 'udi',
    ];

    public const PublicRecordKey = 'record_key';

    public const DeviceIdentifier = 'di';

    public const FullUniqueDeviceIdentifier = 'udi';

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->value = self::OPTIONS[$name];
    }

    public static function publicRecordKey(): self
    {
        return new self('PublicRecordKey');
    }

    public static function deviceIdentifier(): self
    {
        return new self('DeviceIdentifier');
    }

    public static function fullUniqueDeviceIdentifier(): self
    {
        return new self('FullUniqueDeviceIdentifier');
    }

    public function equals(DeviceIdentifierType $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->name === $other->name;
    }

    public function value(): string
    {
        return $this->value;
    }
}
