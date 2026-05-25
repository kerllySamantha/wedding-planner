<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'icono',
        'descripcion',
        'slug',
    ];

    // public function empresas(){
    //     return $this->hasMany(Empresa::class);
    // }

    public function tipoProducto()
    {
        return $this->hasMany(TipoProducto::class);
    }

    public function isBootstrapIcon(): bool
    {
        return is_string($this->icono) && preg_match('/^bi(?:\s|$|-)/', trim($this->icono)) === 1;
    }

    public function isExternalIconUrl(): bool
    {
        return is_string($this->icono) && filter_var(trim($this->icono), FILTER_VALIDATE_URL) !== false;
    }

    public function isStoredIconImage(): bool
    {
        return !empty($this->icono) && !$this->isBootstrapIcon() && !$this->isExternalIconUrl();
    }

    public function iconPreviewUrl(): ?string
    {
        if ($this->isExternalIconUrl()) {
            return trim($this->icono);
        }

        if ($this->isStoredIconImage()) {
            return Storage::disk('public')->url($this->icono);
        }

        return null;
    }

    public function iconPreviewClass(): string
    {
        return $this->isBootstrapIcon() ? trim($this->icono) : 'bi bi-grid-1x2';
    }
}
