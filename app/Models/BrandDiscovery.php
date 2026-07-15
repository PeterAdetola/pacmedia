<?php
// app/Models/BrandDiscovery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BrandDiscovery extends Model
{
    protected $fillable = [
        'client_token', 'token', 'opened_at', 'submitted_at',
        'name', 'brand_name', 'email', 'industry',
        'brand_description', 'existing_brand', 'persona', 'age_min', 'age_max',
        'profile', 'traits', 'colour', 'typography', 'touchpoints',
        'competitors', 'differentiator', 'admired', 'five_year', 'urgency',
        'anything_else', 'status', 'ip_address', 'user_agent', 'expires_at',
    ];

    protected $casts = [
        'profile'      => 'array',
        'traits'       => 'array',
        'colour'       => 'array',
        'typography'   => 'array',
        'touchpoints'  => 'array',
        'age_min'      => 'integer',
        'age_max'      => 'integer',
        'opened_at'    => 'datetime',
        'submitted_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    public const TRAIT_KEYS = [
        'trait_playful_serious', 'trait_approachable_elite', 'trait_casual_elegant',
        'trait_simple_complex', 'trait_classic_contemporary',
        'trait_unconventional_mainstream', 'trait_industrial_natural',
        'trait_feminine_masculine', 'trait_youthful_established',
        'trait_subtle_bright', 'trait_friendly_authoritative',
        'trait_economical_strong', 'trait_empathetic_detached',
        'trait_compassionate_functional', 'trait_diverse_niche', 'trait_local_global',
    ];

    /** Full pipeline, in order. */
    public const STATUSES = ['sent', 'opened', 'submitted', 'reviewed', 'archived'];

    /** Statuses that mean "a real submission exists" (form was completed). */
    public const SUBMITTED_STATUSES = ['submitted', 'reviewed', 'archived'];

    public function isSubmitted(): bool
    {
        return in_array($this->status, self::SUBMITTED_STATUSES, true);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['sent', 'opened']);
    }

    public function scopeNeedsReview($query)
    {
        return $query->where('status', 'submitted');
    }

    /** Generate a guaranteed-unique, unguessable link token. */
    public static function generateToken(): string
    {
        do {
            $token = Str::random(40);
        } while (self::where('token', $token)->exists());

        return $token;
    }

    /** How long a generated link stays valid before it's considered stale. */
    public const DEFAULT_EXPIRY_DAYS = 7;

    public function isExpired(): bool
    {
        return $this->expires_at !== null
            && $this->expires_at->isPast()
            && !$this->isSubmitted();   // a submitted link is never "expired" — it's just locked
    }
}
