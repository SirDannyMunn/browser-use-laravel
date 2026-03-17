<?php

namespace BrowserUseLaravel\Support;

final class BrowserUseBaseUrl
{
    public static function normalize(?string $baseUrl, ?string $appUrl = null): string
    {
        $normalizedBaseUrl = rtrim(trim((string) $baseUrl), '/');
        $normalizedAppUrl = rtrim(trim((string) $appUrl), '/');

        if ($normalizedBaseUrl === '') {
            return $normalizedBaseUrl;
        }

        $baseParts = parse_url($normalizedBaseUrl);
        $appParts = $normalizedAppUrl !== '' ? parse_url($normalizedAppUrl) : false;

        if (!is_array($baseParts) || !is_array($appParts)) {
            return $normalizedBaseUrl;
        }

        $baseHost = strtolower((string) ($baseParts['host'] ?? ''));
        $appHost = strtolower((string) ($appParts['host'] ?? ''));
        $baseScheme = strtolower((string) ($baseParts['scheme'] ?? ''));
        $appScheme = strtolower((string) ($appParts['scheme'] ?? ''));
        $basePath = trim((string) ($baseParts['path'] ?? ''));

        if (
            $baseHost === ''
            || $appHost === ''
            || $baseHost !== $appHost
            || $baseScheme === ''
            || $appScheme === ''
            || $baseScheme === $appScheme
            || $basePath !== '/api/v2'
        ) {
            return $normalizedBaseUrl;
        }

        $basePort = isset($baseParts['port']) ? (int) $baseParts['port'] : null;
        $appPort = isset($appParts['port']) ? (int) $appParts['port'] : null;
        if ($basePort !== $appPort) {
            return $normalizedBaseUrl;
        }

        $normalized = $appScheme . '://' . $baseHost;
        if ($basePort !== null) {
            $normalized .= ':' . $basePort;
        }

        $normalized .= $basePath;

        if (isset($baseParts['query']) && $baseParts['query'] !== '') {
            $normalized .= '?' . $baseParts['query'];
        }

        if (isset($baseParts['fragment']) && $baseParts['fragment'] !== '') {
            $normalized .= '#' . $baseParts['fragment'];
        }

        return $normalized;
    }
}
