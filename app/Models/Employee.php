<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $fillable = [
        'name',
        'email',
        'employee_id',
        'birth_city',
        'birth',
        'age',
        'phone',
        'gander',
        'address',
        'id_card_number',
        'id_card_image',
        'is_delete',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function filter($filter = []){
        return $this->when(isset($filter['search']), function($query) use ($filter) {
                return $query->where('name', 'like', "%$filter[search]%")
                            ->orWhere('email', 'like', "%$filter[search]%")
                            ->orWhere('employee_id', 'like', "%$filter[search]%")
                            ->orWhere('birth_city', 'like', "%$filter[search]%");
            })
            ->when(isset($filter['delete']), function ($query) use ($filter) {
                return $query->where('is_delete', $filter['delete']);
            });
    }
}
