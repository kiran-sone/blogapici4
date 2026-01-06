<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table            = 'posts';
    protected $primaryKey       = 'pid';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'p_title',
        'p_descr',
        'cat_id',
        'updated_at',
    ];
}
