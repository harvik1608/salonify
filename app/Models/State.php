<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class State extends Model
    {
        use HasFactory, SoftDeletes;

        protected $fillable = [
            'name',
            'country_id',
            'is_active',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        protected $casts = [
            'is_active' => 'boolean',
        ];

        public function country()
        {
            return $this->belongsTo(Country::class);
        }
    }
