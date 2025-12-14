<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_code',
        'total_amount',
        'status',
        'payment_method',
        'paid_at',
        'payment_proof',
        'shipping_address',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateTransactionCode()
    {
        return 'TRX' . date('YmdHis') . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-secondary',
            'paid' => 'bg-primary',
            'processing' => 'bg-info',
            'ready_pickup' => 'bg-warning text-dark',
            'shipped' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
        ];
        
        // Label status dalam bahasa Indonesia
        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Menunggu Konfirmasi',
            'paid' => 'Dibayar',
            'ready_pickup' => 'Siap Diambil',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $label = $statusLabels[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
        return '<span class="badge ' . ($badges[$this->status] ?? 'bg-secondary') . '">' . $label . '</span>';
    }

    public function getPaymentProofUrlAttribute()
    {
        if ($this->payment_proof) {
            // Check new location first (public disk)
            $storagePath = storage_path('app/public/payments/' . $this->payment_proof);
            if (file_exists($storagePath)) {
                return asset('storage/payments/' . $this->payment_proof);
            }
            
            // Check old location (local disk with public prefix)
            $oldPath = storage_path('app/private/public/payments/' . $this->payment_proof);
            if (file_exists($oldPath)) {
                return asset('storage/payments/' . $this->payment_proof);
            }
            
            // Fallback: return URL anyway (for database entries that exist)
            return asset('storage/payments/' . $this->payment_proof);
        }
        return null;
    }
}