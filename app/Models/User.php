<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $only)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function animals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Animal');
    }

    public function getAnimalNames(): array
    {
        return array_column($this->animals()->getModels(), 'animal_name');
    }

    public function getImplodedAnimalNames(): string
    {
        return join(', ', $this->getAnimalNames());
    }

    public function getAnimal(): array
    {
        return $this->animals()->getModels();
    }

    public function getAnimalId(): array
    {
        return array_column($this->animals()->getModels(), 'id');
    }


}
