<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
    use HasFactory;

    protected $table = 'form_questions';

    protected $fillable = [
        'system_key',
        'pertanyaan',
        'tipe_input',
        'opsi',
        'wajib',
        'urutan',
        'status',
    ];

    protected $casts = [
        'wajib' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Helper to get options as array
     */
    public function getOpsiArrayAttribute()
    {
        if (empty($this->opsi)) {
            return [];
        }

        // Split by newline or comma
        return array_map('trim', preg_split('/[\r\n,]+/', $this->opsi, -1, PREG_SPLIT_NO_EMPTY));
    }
}
