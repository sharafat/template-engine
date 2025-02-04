<?php

namespace App\Models\Template\Traits;

trait ContentSettings
{
    public const CONTENT_SIZE_WIDTH = 'content_size_width';
    public const CONTENT_SIZE_HEIGHT = 'content_size_height';
    public const CONTENT_MIN_SIZE_WIDTH = 'content_min_size_width';
    public const CONTENT_MIN_SIZE_HEIGHT = 'content_min_size_height';
    public const CONTENT_MAX_SIZE_WIDTH = 'content_max_size_width';
    public const CONTENT_MAX_SIZE_HEIGHT = 'content_max_size_height';
    public const CONTENT_MARGIN = 'content_margin';
    public const CONTENT_PADDING = 'content_padding';
    public const CONTENT_ZOOM = 'content_zoom';
    public const CONTENT_BG_IMAGE = 'content_bg_image';
    public const SHOW_LOGO_WATERMARK = 'show_logo_watermark';
    public const LOGO_WATERMARK_OPACITY = 'logo_watermark_opacity';
    public const LOGO_WATERMARK_WIDTH = 'logo_watermark_width';
    public const LOGO_WATERMARK_HEIGHT = 'logo_watermark_height';
    public const LOGO_WATERMARK_POSITION = 'logo_watermark_position';

    public const CONTENT_SETTINGS = [
        self::CONTENT_SIZE_WIDTH,
        self::CONTENT_SIZE_HEIGHT,
        self::CONTENT_MIN_SIZE_WIDTH,
        self::CONTENT_MIN_SIZE_HEIGHT,
        self::CONTENT_MAX_SIZE_WIDTH,
        self::CONTENT_MAX_SIZE_HEIGHT,
        self::CONTENT_MARGIN,
        self::CONTENT_PADDING,
        self::CONTENT_ZOOM,
        self::CONTENT_BG_IMAGE,
        self::SHOW_LOGO_WATERMARK,
        self::LOGO_WATERMARK_OPACITY,
        self::LOGO_WATERMARK_WIDTH,
        self::LOGO_WATERMARK_HEIGHT,
        self::LOGO_WATERMARK_POSITION,
    ];

    public const CONTENT_SETTINGS_VALIDATION_RULES = [
        self::CONTENT_SIZE_WIDTH      => 'nullable|string|max:20',
        self::CONTENT_SIZE_HEIGHT     => 'nullable|string|max:20',
        self::CONTENT_MIN_SIZE_WIDTH  => 'nullable|string|max:20',
        self::CONTENT_MIN_SIZE_HEIGHT => 'nullable|string|max:20',
        self::CONTENT_MAX_SIZE_WIDTH  => 'nullable|string|max:20',
        self::CONTENT_MAX_SIZE_HEIGHT => 'nullable|string|max:20',
        self::CONTENT_MARGIN          => 'nullable|string|max:40',
        self::CONTENT_PADDING         => 'nullable|string|max:40',
        self::CONTENT_ZOOM            => 'nullable|string|max:20',
        self::CONTENT_BG_IMAGE        => 'nullable|file|max:512|mimes:png,jpg,jpeg',
        self::SHOW_LOGO_WATERMARK     => 'nullable|bool_val',
        self::LOGO_WATERMARK_OPACITY  => 'nullable|integer|min:0|max:100',
        self::LOGO_WATERMARK_WIDTH    => 'nullable|string|max:20',
        self::LOGO_WATERMARK_HEIGHT   => 'nullable|string|max:20',
        self::LOGO_WATERMARK_POSITION => 'nullable|string|max:40',
    ];
}
