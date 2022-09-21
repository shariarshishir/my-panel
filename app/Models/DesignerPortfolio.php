<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerPortfolio extends Model
{
    use HasFactory;

    protected $fillable=['designer_id', 'image'];

    protected $table = "designer_portfolio";

    public function designers()
    {
        return $this->belongsTo(Designers::class);
    }
}
