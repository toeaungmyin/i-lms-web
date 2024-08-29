<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'id_prefix',
        'curr_id_index',
        'is_active',
    ];

    public function generate_id()
    {
        $index = $this->curr_id_index + 1;
        $new_std_id = $this->id_prefix . '-' . str_pad($index, 4, '0', STR_PAD_LEFT);
        return $new_std_id;
    }

    public function update_id_index()
    {
        $this->curr_id_index = $this->curr_id_index + 1;
        $this->save();
    }
}
