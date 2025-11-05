<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Tagline extends Model
    {
        use HasFactory, SoftDeletes;

        // protected $table = 'languages';

        protected $fillable = [
            'title',
            'description',
            'is_active',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        protected $casts = [
            'is_active' => 'boolean',
        ];
    }
