<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'apply_date',
        'first_name',
        'last_name',
        'furigana_first_name',
        'furigana_last_name',
        'gender',
        'age',
        'post_code',
        'prefecture',
        'city',
        'additional_address',
        'room_building_number',
        'telephone',
        'user_id',
        'qanda',
        'apply_id',
        'gift_id',
        'gift_name',
    ];

    protected $appends = [
        'full_name',
        'furigana_full_name',
    ];

    protected $casts = [
        'qanda' =>  AsCollection::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->apply_id = (string)Str::orderedUuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute(): string {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFuriganaFullNameAttribute(): string {
        return $this->furigana_first_name . ' ' . $this->furigana_last_name;
    }

    /**
     * @param $value
     */
    public function setCityAttribute($value) {
        $this->attributes['city'] = mb_convert_kana($value, 'AS');
    }

    /**
     * @param $value
     */
    public function setAdditionalAddressAttribute($value) {
        $this->attributes['additional_address'] = mb_convert_kana($value, 'AS');
    }
}
