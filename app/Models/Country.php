<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Country extends Model
    {
        use HasFactory, SoftDeletes;

        protected $fillable = [
            'name',
            'country_code',
            'currency_code',
            'flag',
            'is_active',
            'created_by',
            'updated_by',
            'deleted_by',
        ];

        protected $casts = [
            'is_active' => 'boolean',
        ];

        public function states()
        {
            return $this->hasMany(State::class);
        }
    }
