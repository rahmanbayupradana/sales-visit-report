<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Visit extends Model
{
    //
     protected $fillable = [
        'user_id',
        'institution_id',
        'visit_type_id',
        'visit_result_id',
        'visit_date',
        'visit_time',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Visit dimiliki oleh satu sales/user.
     */
    public function sales(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Visit dimiliki oleh satu institution.
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class,'institution_id');
    }

    /**
     * Visit memiliki satu jenis kunjungan.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(VisitType::class, 'visit_type_id');
    }

    /**
     * Visit memiliki satu hasil.
     */
    public function result(): BelongsTo
    {
        return $this->belongsTo(VisitResult::class, 'visit_result_id');
    }
}
