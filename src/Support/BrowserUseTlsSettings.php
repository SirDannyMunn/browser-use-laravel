<?php

namespace BrowserUseLaravel\Support;

final class BrowserUseTlsSettings
{
    /**
     * @return bool|string|null
     */
    public static function resolveVerifyOption(
        ?string $baseUrl,
        mixed $verifySetting = null,
        ?string $caBundle = null,
        ?string $environment = null,
    ): bool|string|null {
        $normalizedCaBundle = trim((string) $caBundle);
        $normalizedEnvironment = strtolower(trim((string) $environment));

        if (is_string($verifySetting)) {
            $normalizedVerify = strtolower(trim($verifySetting));
            if (in_array($normalizedVerify, ['0', 'false', 'off', 'no'], true)) {
                return false;
            }

            if (in_array($normalizedVerify, ['1', 'true', 'on', 'yes'], true)) {
                return $normalizedCaBundle !== '' ? $normalizedCaBundle : null;
            }
        }

        if (is_bool($verifySetting)) {
            if ($verifySetting === false) {
                return false;
            }

            return $normalizedCaBundle !== '' ? $normalizedCaBundle : null;
        }

        if ($normalizedCaBundle !== '') {
            return $normalizedCaBundle;
        }

        $host = strtolower((string) parse_url((string) $baseUrl, PHP_URL_HOST));
        if (
            $normalizedEnvironment === 'local'
            && $host !== ''
            && preg_match('/(\.test|\.localhost|\.local|\.dev)$/', $host) === 1
        ) {
            return false;
        }

        return null;
    }
}
