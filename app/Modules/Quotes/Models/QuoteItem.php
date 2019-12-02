<?php

/**
 * InvoicePlane
 *
 * @package     InvoicePlane
 * @author      InvoicePlane Developers & Contributors
 * @copyright   Copyright (C) 2014 - 2018 InvoicePlane
 * @license     https://invoiceplane.com/license
 * @link        https://invoiceplane.com
 *
 * Based on FusionInvoice by Jesse Terry (FusionInvoice, LLC)
 */

namespace FI\Modules\Quotes\Models;

use FI\Events\QuoteItemSaving;
use FI\Events\QuoteModified;
use FI\Support\CurrencyFormatter;
use FI\Support\NumberFormatter;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($quoteItem) {
            $quoteItem->amount()->delete();
        });

        static::deleted(function ($quoteItem) {
            if ($quoteItem->quote) {
                event(new QuoteModified($quoteItem->quote));
            }
        });

        static::saving(function ($quoteItem) {
            event(new QuoteItemSaving($quoteItem));
        });

        static::saved(function ($quoteItem) {
            event(new QuoteModified($quoteItem->quote));
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function amount()
    {
        return $this->hasOne('FI\Modules\Quotes\Models\QuoteItemAmount', 'item_id');
    }

    public function quote()
    {
        return $this->belongsTo('FI\Modules\Quotes\Models\Quote');
    }

    public function taxRate()
    {
        return $this->belongsTo('FI\Modules\TaxRates\Models\TaxRate');
    }

    public function taxRate2()
    {
        return $this->belongsTo('FI\Modules\TaxRates\Models\TaxRate', 'tax_rate_2_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedQuantityAttribute()
    {
        return NumberFormatter::format($this->attributes['quantity']);
    }

    public function getFormattedNumericPriceAttribute()
    {
        return NumberFormatter::format($this->attributes['price']);
    }

    public function getFormattedPriceAttribute()
    {
        return CurrencyFormatter::format($this->attributes['price'], $this->quote->currency);
    }

    public function getFormattedDescriptionAttribute()
    {
        return nl2br($this->attributes['description']);
    }
}