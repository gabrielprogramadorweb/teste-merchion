<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class TaskComentarios extends Model
    {

        protected $table = 'task_comentarios';

        protected $fillable = [
            'task_id',
            'user_id',
            'comentario',
        ];

        public function task()
        {
            return $this->belongsTo(Task::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
