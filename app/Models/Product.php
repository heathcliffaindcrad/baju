<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'size',
        'color',
        'price',
        'stock',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if file exists with original extension
            $storagePath = storage_path('app/public/products/' . $this->image);
            if (file_exists($storagePath)) {
                return asset('storage/products/' . $this->image);
            }
            
            // Try different formats
            $baseName = pathinfo($this->image, PATHINFO_FILENAME);
            $formats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            foreach ($formats as $format) {
                $testPath = storage_path('app/public/products/' . $baseName . '.' . $format);
                if (file_exists($testPath)) {
                    return asset('storage/products/' . $baseName . '.' . $format);
                }
            }
        }
        
        return asset('images/default-product.svg');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        $threshold = Setting::first()->low_stock_threshold ?? 10;
        return $query->where('stock', '<=', $threshold);
    }
}