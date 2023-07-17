<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'date', 'score'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($score) {
            Cache::tags([$score->subject->name])->forget("avg_scores_{$score->subject->name}");
        });
    }

    public $timestamps = false;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
