<?php

namespace App\Support;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class MarkdownComponents
{
    protected const COMPONENT_MAP = [
        'api-request' => 'components.api-request',
        'api-response' => 'components.api-response',
    ];

    /**
     * Render markdown + custom component shortcodes safely (avoid re-markdown).
     */
    public static function render(string $markdown): string
    {
        $rendered = [];
        $index = 0;

        $withPlaceholders = preg_replace_callback('/\\[(api-request|api-response)(\\s+[^\\]]*)?\\]/', function ($matches) use (&$rendered, &$index) {
            $tag = $matches[1];
            $rawAttributes = $matches[2] ?? '';
            $data = static::parseAttributes($rawAttributes);

            $view = static::COMPONENT_MAP[$tag] ?? null;
            if (!$view || !View::exists($view)) {
                return $matches[0];
            }

            // Pakai placeholder yang tidak diubah oleh Markdown (tanpa underscore/glyph khusus)
            $placeholder = 'MCMPBLOCK-' . $index . '-PLACEHOLDER';
            $index++;
            $rendered[$placeholder] = View::make($view, $data)->render();
            return $placeholder;
        }, $markdown);

        $html = Str::markdown($withPlaceholders);

        foreach ($rendered as $placeholder => $componentHtml) {
            $html = str_replace(
                [
                    $placeholder,
                    '<p>' . $placeholder . '</p>',
                    "<p>{$placeholder}</p>\n",
                    "<p>{$placeholder}</p>",
                    "<pre><code>{$placeholder}</code></pre>",
                    "<code>{$placeholder}</code>",
                ],
                $componentHtml,
                $html
            );
        }

        return $html;
    }

    protected static function parseAttributes(string $raw): array
    {
        $attributes = [];

        $len = strlen($raw);
        $i = 0;

        while ($i < $len) {
            // skip spaces
            while ($i < $len && ctype_space($raw[$i])) {
                $i++;
            }
            if ($i >= $len) {
                break;
            }

            // read key
            $key = '';
            while ($i < $len && $raw[$i] !== '=' && !ctype_space($raw[$i])) {
                $key .= $raw[$i];
                $i++;
            }
            if ($key === '' || $i >= $len || $raw[$i] !== '=') {
                $i++;
                continue;
            }
            $i++; // skip '='

            // skip spaces before value
            while ($i < $len && ctype_space($raw[$i])) {
                $i++;
            }
            if ($i >= $len) {
                break;
            }

            $value = '';
            $startChar = $raw[$i];

            if ($startChar === '"' || $startChar === "'") {
                $quote = $startChar;
                $i++;
                while ($i < $len && $raw[$i] !== $quote) {
                    $value .= $raw[$i];
                    $i++;
                }
                $i++; // skip closing quote
            } elseif ($startChar === '{' || $startChar === '[') {
                $open = $startChar;
                $close = $startChar === '{' ? '}' : ']';
                $depth = 0;
                while ($i < $len) {
                    $char = $raw[$i];
                    $value .= $char;
                    if ($char === $open) {
                        $depth++;
                    } elseif ($char === $close) {
                        $depth--;
                        if ($depth === 0) {
                            $i++;
                            break;
                        }
                    }
                    $i++;
                }
            } else {
                while ($i < $len && !ctype_space($raw[$i])) {
                    $value .= $raw[$i];
                    $i++;
                }
            }

            if (str_starts_with($key, ':')) {
                $key = substr($key, 1);
                $decoded = json_decode($value, true);
                $attributes[$key] = $decoded === null ? $value : $decoded;
            } else {
                $attributes[$key] = $value;
            }

            if (str_contains($key, '-')) {
                $attributes[Str::camel($key)] = $attributes[$key];
            }
        }

        return $attributes;
    }
}
