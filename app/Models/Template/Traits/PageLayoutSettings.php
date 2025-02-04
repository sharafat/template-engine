<?php

namespace App\Models\Template\Traits;

trait PageLayoutSettings
{
    public const PAGE_SIZE = 'page_size';
    public const PAGE_ORIENTATION = 'page_orientation';
    public const PAGE_MARGIN = 'page_margin';
    public const PAGE_BORDER = 'page_border';
    public const ITEMS_PER_PAGE = 'items_per_page';
    public const ITEMS_HORIZONTAL_GAP = 'items_horizontal_gap';
    public const ITEMS_VERTICAL_GAP = 'items_vertical_gap';

    public const PAGE_LAYOUT_SETTINGS = [
        self::PAGE_SIZE,
        self::PAGE_ORIENTATION,
        self::PAGE_MARGIN,
        self::PAGE_BORDER,
        self::ITEMS_PER_PAGE,
        self::ITEMS_HORIZONTAL_GAP,
        self::ITEMS_VERTICAL_GAP,
    ];
}
