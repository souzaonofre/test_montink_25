<?php

declare(strict_types=1);

namespace Onofre\TestMontink25\System\Http;

use Nyholm\Psr7\Uri;
use Nyholm\Psr7\Stream;
use InvalidArgumentException;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpRequest implements MessageInterface, ServerRequestInterface
{

    /**
     * @var string[]
     */
    private static array $supportedProtocolVersions = ['1.0', '1.1', '2.0', '2'];

    /**
     * @var string
     */
    private string $protocol = '1.1';

    /**
     * @var string
     */
    private string $method = 'GET';

    /**
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * @var string[]
     */
    private array $headers = [];

    /**
     * @var string[]
     */
    private array $headerNames = [];

    /**
     * @var null|string
     */
    private ?string $requestTarget = null;

    /**
     * @var string|null
     */
    private ?string $body = null;

    /**
     * @var StreamInterface|null
     */
    private ?StreamInterface $stream;

    /**
     * @var array
     */
    private array $attributes = [];

    /**
     * @var array
     */
    private array $cookieParams = [];

    /**
     * @var array
     */
    private array $queryParams = [];

    /**
     * @var array
     */
    private array $serverParams = [];

    /**
     * @var array
     */
    private array $uploadedFiles = [];



    public function __construct(
        string $method = 'GET',
        string $uri,
        array $headers = [],
        ?string $body = null,
        string $protocol = '1.1',
        array $uploadedFiles = [],
        array $serverParams = [],
        array $cookieParams = [],
        array $queryParams = []
    ) {
        $this->init($method, $uri, $headers, $body, $protocol);
        $this->uploadedFiles = $this->validateUploadedFiles($uploadedFiles);
        $this->serverParams = $serverParams;
        $this->cookieParams = $cookieParams;
        $this->queryParams = $queryParams;
    }

    private function init(
        string $method = 'GET',
        string $uri = '',
        array $headers = [],
        $body = null,
        string $protocol = '1.1'
    ): void {

        $this->method = $method;
        $this->body = $body;
        $this->setUri($uri);

        $this->registerStream($body);
        $this->registerHeaders($headers);
        $this->registerProtocolVersion($protocol);
    }

    private function validateUploadedFiles(array $uploadedFiles): array
    {
        return $uploadedFiles;
    }

    private function registerStream($stream, string $mode = 'wb+'): void
    {
        if ($stream === null || $stream instanceof StreamInterface) {
            $this->stream = $stream;
            return;
        }

        if (is_string($stream) || is_resource($stream)) {
            $this->stream = new Stream($stream, $mode);
            return;
        }

        throw new InvalidArgumentException(sprintf(
            ' 
                Stream must be a `Psr\Http\Message\StreamInterface` implementation 
                    or null or a string or a stream resource identifier;
                The current $stream value is: `%s`.
            ',
            (is_object($stream) ? get_class($stream) : gettype($stream))
        ));
    }


    private function sanatizeHeaderName($name): string
    {
        if (!is_string($name) || !preg_match('/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/D', $name)) {
            throw new InvalidArgumentException(sprintf(
                '`%s` is not valid header name.',
                (is_object($name) ? get_class($name) : (is_string($name) ? $name : gettype($name)))
            ));
        }

        return strtolower($name);
    }

    private function sanatizeHeaderValue($value): array
    {
        $value = is_array($value) ? array_values($value) : [$value];

        if (empty($value)) {
            throw new InvalidArgumentException(
                'Header value must be a string or an array of strings, empty array given.',
            );
        }

        $normalizedValues = [];

        foreach ($value as $v) {
            if ((!is_string($v) && !is_numeric($v)) || !preg_match('/^[ \t\x21-\x7E\x80-\xFF]*$/D', (string) $v)) {
                throw new InvalidArgumentException(sprintf(
                    '"%s" is not valid header value.',
                    (is_object($v) ? get_class($v) : (is_string($v) ? $v : gettype($v)))
                ));
            }

            $normalizedValues[] = trim((string) $v, " \t");
        }

        return $normalizedValues;
    }

    private function registerHeaders(array $originalHeaders = []): void
    {
        $this->headers = [];
        $this->headerNames = [];

        foreach ($originalHeaders as $name => $value) {
            $this->headerNames[$this->sanatizeHeaderName($name)] = $name;
            $this->headers[$name] = $this->sanatizeHeaderValue($value);
        }
    }

    private function validateProtocolVersion($protocol): void
    {
        if (!in_array($protocol, self::$supportedProtocolVersions, true)) {
            throw new InvalidArgumentException(sprintf(
                'Unsupported HTTP protocol version "%s" provided. The following strings are supported: "%s".',
                is_string($protocol) ? $protocol : gettype($protocol),
                implode('", "', self::$supportedProtocolVersions),
            ));
        }
    }

    private function registerProtocolVersion(string $protocol): void
    {
        if (!empty($protocol) && $protocol !== $this->protocol) {
            $this->validateProtocolVersion($protocol);
            $this->protocol = $protocol;
        }
    }

    private function setUri(string $uri): void
    {
        if ($uri instanceof UriInterface) {
            $this->uri = $uri;
            return;
        }

        if (is_string($uri)) {
            $this->uri = new Uri($uri);
            return;
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" is not valid URI.',
            (is_object($uri) ? get_class($uri) : gettype($uri))
        ));
    }
}
