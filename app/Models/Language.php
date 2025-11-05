<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Language extends Model
    {
        use HasFactory, SoftDeletes;

        // protected $table = 'languages';

        protected $fillable = [
            'name',
            'code',
            'is_active',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        protected $casts = [
            'is_active' => 'boolean',
        ];
    }
