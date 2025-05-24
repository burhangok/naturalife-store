<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class CommissionRule extends Model
{
    use HasFactory;

    protected $table = 'commission_rules';

    protected $fillable = [
        'level',
        'percentage',
        'is_active',
        'created_admin_id',
        'updated_admin_id',
    ];

    /**
     * Kurala oluşturmayı onaylayan admin
     */
    public function creator()
    {
        return $this->belongsTo(\Webkul\User\Models\Admin::class, 'created_admin_id');
    }

    /**
     * Kurala en son güncellemeyi yapan admin
     */
    public function updater()
    {
        return $this->belongsTo(\Webkul\User\Models\Admin::class, 'updated_admin_id');
    }

    /**
     * Aktif kuralları filtrele
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
