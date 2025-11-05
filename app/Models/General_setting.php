<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class General_setting extends Model
    {
        use HasFactory;

        protected $fillable = [
            'setting_key',
            'setting_val'
        ];
    }
