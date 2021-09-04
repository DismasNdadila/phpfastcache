<?php
/**
 *
 * This file is part of Phpfastcache.
 *
 * @license MIT License (MIT)
 *
 * For full copyright and license information, please see the docs/CREDITS.txt and LICENCE files.
 *
 * @author Georges.L (Geolim4)  <contact@geolim4.com>
 * @author Contributors  https://github.com/PHPSocialNetwork/phpfastcache/graphs/contributors
 */

declare(strict_types=1);

namespace Phpfastcache\Drivers\Memcached;

use Phpfastcache\Config\ConfigurationOption;
use Phpfastcache\Exceptions\PhpfastcacheInvalidConfigurationException;

class Config extends ConfigurationOption
{
    /**
     * @var array
     *
     * Multiple server can be added this way:
     *       $cfg->setServers([
     *         [
     *           'host' => '127.0.0.1',
     *           'port' => 11211,
     *           'saslUser' => false,
     *           'saslPassword' => false,
     *         ]
     *      ]);
     */
    protected array $servers = [];

    /**
     * @var string
     */
    protected string $host = '127.0.0.1';

    /**
     * @var int
     */
    protected int $port = 11211;

    /**
     * @var string
     */
    protected string $saslUser = '';

    /**
     * @var string
     */
    protected string $saslPassword = '';

    /**
     * @var string
     */
    protected string $optPrefix = '';

    /**
     * @return string
     */
    public function getSaslUser(): string
    {
        return $this->saslUser;
    }

    /**
     * @param string $saslUser
     * @return self
     */
    public function setSaslUser(string $saslUser): static
    {
        $this->saslUser = $saslUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getSaslPassword(): string
    {
        return $this->saslPassword;
    }

    /**
     * @param string $saslPassword
     * @return self
     */
    public function setSaslPassword(string $saslPassword): static
    {
        $this->saslPassword = $saslPassword;
        return $this;
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        if (!count($this->servers)) {
            return [
                [
                    'host' => $this->getHost(),
                    'path' => $this->getPath(),
                    'port' => $this->getPort(),
                    'saslUser' => $this->getSaslUser() ?: false,
                    'saslPassword' => $this->getSaslPassword() ?: false,
                ],
            ];
        }

        return $this->servers;
    }

    /**
     * @param array $servers
     * @return self
     * @throws PhpfastcacheInvalidConfigurationException
     */
    public function setServers(array $servers): static
    {
        foreach ($servers as $server) {
            if ($diff = array_diff(['host', 'port', 'saslUser', 'saslPassword'], array_keys($server))) {
                throw new PhpfastcacheInvalidConfigurationException('Missing keys for memcached server: ' . implode(', ', $diff));
            }
            if ($diff = array_diff(array_keys($server), ['host', 'port', 'saslUser', 'saslPassword'])) {
                throw new PhpfastcacheInvalidConfigurationException('Unknown keys for memcached server: ' . implode(', ', $diff));
            }
            if (!is_string($server['host'])) {
                throw new PhpfastcacheInvalidConfigurationException('Host must be a valid string in "$server" configuration array');
            }
            if (!is_int($server['port'])) {
                throw new PhpfastcacheInvalidConfigurationException('Port must be a valid integer in "$server" configuration array');
            }
        }
        $this->servers = $servers;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return self
     */
    public function setHost(string $host): static
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return Config
     */
    public function setPort(int $port): static
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     * @since 8.0.2
     */
    public function getOptPrefix(): string
    {
        return $this->optPrefix;
    }

    /**
     * @param string $optPrefix
     * @return Config
     * @since 8.0.2
     */
    public function setOptPrefix(string $optPrefix): Config
    {
        $this->optPrefix = trim($optPrefix);
        return $this;
    }
}
