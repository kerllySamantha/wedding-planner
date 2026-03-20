<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\Empty_;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function bodas()
    {
        return $this->hasMany(Boda::class);
    }

    // function rol()
    // {
    //     $this->belongsTo(Rol::class, 'id_rol', 'id');
    // }

    function resenias(){
       return  $this->hasMany(Resenia::class);
    }

    function empresa(){
       return  $this->hasOne(Empresa::class);
    }

    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'emisor_id');
    }

    // public function mensajesRecibidos()
    // {
    //     return $this->hasMany(Mensaje::class, 'receptor_id');
    //}

    public function reservas(){
        return $this->hasMany(Reserva::class, 'user_id' );
    }

    public function perfil(){
        return $this->hasOne(PerfilUsuario::class);
    }

    public function invitado()
    {
        return $this->hasOne(Invitado::class);
    }

    public function pedirPresupuestos()
    {
        return $this->hasMany(PedirPresupuesto::class, 'user_id');
    }
}
