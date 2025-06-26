<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['titulo', 'descricao', 'status', 'data_vencimento', 'prioridade', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag');
    }

    // Relacionamento com comentários
    public function comments()
    {
        return $this->hasMany(TaskComentarios::class);
    }
}
