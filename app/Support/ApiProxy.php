<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiProxy
{
    /**
     * Jalankan proxy request dengan validasi prefix agar tidak jadi open-proxy.
     */
    public static function handle(Request $request, string $path, string $baseUrl): Response
    {
        $allowedPrefixes = [
            'MmCoreCzLinkHost/',
            'MmCorePsgsHost/',
            'MmCoreQrpsHost/',
            'MmCoreQrpssHost/',
            'MmCoreBnplHost/',
            'mini-atm/',
            'partner/',
            'api/',
        ];

        $normalizedPath = ltrim($path, '/');
        $pathInfo = $request->getPathInfo();
        if (str_ends_with($pathInfo, '/') && !str_ends_with($normalizedPath, '/')) {
            $normalizedPath .= '/';
        }

        $isAllowed = false;
        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($normalizedPath, $prefix)) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed) {
            abort(404);
        }

        $targetUrl = rtrim($baseUrl, '/') . '/' . $normalizedPath;
        $query = http_build_query($request->query());
        $finalUrl = $query ? $targetUrl . '?' . $query : $targetUrl;

        $excludedHeaders = [
            'host',
            'connection',
            'content-length',
            'accept-encoding',
            'origin',
            'referer',
            'cookie',
        ];

        $forwardHeaders = [];
        foreach ($request->headers->all() as $key => $values) {
            if (in_array(strtolower($key), $excludedHeaders, true)) {
                continue;
            }
            $forwardHeaders[$key] = implode(', ', $values);
        }

        $curl = curl_init($finalUrl);
        if ($curl === false) {
            abort(500, 'Failed to initialize proxy request.');
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->method());
        curl_setopt($curl, CURLOPT_HTTPHEADER, array_map(
            fn ($key, $value) => $key . ': ' . $value,
            array_keys($forwardHeaders),
            $forwardHeaders
        ));

        $body = $request->getContent();
        if ($body !== '') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        $rawResponse = curl_exec($curl);
        if ($rawResponse === false) {
            $error = curl_error($curl);
            curl_close($curl);
            abort(502, $error ?: 'Proxy request failed.');
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        curl_close($curl);

        $rawHeaders = substr($rawResponse, 0, $headerSize);
        $responseBody = substr($rawResponse, $headerSize);

        $responseHeaders = [];
        foreach (preg_split('/\r\n|\r|\n/', trim($rawHeaders)) as $headerLine) {
            if (stripos($headerLine, 'HTTP/') === 0) {
                continue;
            }
            $parts = explode(':', $headerLine, 2);
            if (count($parts) !== 2) {
                continue;
            }
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            if (in_array(strtolower($key), ['transfer-encoding', 'connection'], true)) {
                continue;
            }
            $responseHeaders[$key] = $value;
        }

        return response($responseBody, $status)->withHeaders($responseHeaders);
    }
}
