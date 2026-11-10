<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class VideoJuego extends Model
{
    use HasFactory;

    protected $table = 'videojuegos';

    protected $fillable = [
        'titulo',
        'plataforma',
        'precio',
        'stock',
        'categoria_id',
        'descripcion',
        'imagen',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    // La imagen puede ser una URL externa (Steam) o un archivo subido al disco publico.
    protected function imagenUrl(): Attribute
    {
        return Attribute::get(fn () => match (true) {
            ! $this->imagen => null,
            Str::startsWith($this->imagen, ['http://', 'https://']) => $this->imagen,
            default => asset('storage/' . $this->imagen),
        });
    }

    // Arte horizontal para fondos amplios; en Steam es la ilustracion sin logo pensada para recortarse.
    protected function fondoUrl(): Attribute
    {
        return Attribute::get(fn () => Str::endsWith((string) $this->imagen, 'library_600x900.jpg')
            ? Str::replaceLast('library_600x900.jpg', 'library_hero.jpg', $this->imagen)
            : $this->imagen_url);
    }

    // ── Relaciones ──────────────────────────────────────

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function dlcs(): HasMany
    {
        return $this->hasMany(Dlc::class, 'videojuego_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'videojuego_id');
    }

    public function requisitosMinimosPC(): HasOne
    {
        return $this->hasOne(RequisitosMinimosPc::class, 'videojuego_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'videojuego_id');
    }

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'videojuego_id');
    }

    // ── Scopes ──────────────────────────────────────────

    public function scopeEnStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    // ── Accessors ───────────────────────────────────────

    public function getPromedioCalificacionAttribute(): ?float
    {
        $promedio = $this->resenas()->avg('calificacion');

        return $promedio ? round($promedio, 1) : null;
    }

    // Filtros del catalogo publico; cada uno se aplica solo si viene con valor.
    public function scopeFiltrar(Builder $query, array $filtros): Builder
    {
        return $query
            ->when($filtros['categoria'] ?? null, fn ($consulta, $categoria) => $consulta->where('categoria_id', $categoria))
            ->when($filtros['plataforma'] ?? null, fn ($consulta, $plataforma) => $consulta->where('plataforma', $plataforma))
            ->when($filtros['precio_min'] ?? null, fn ($consulta, $minimo) => $consulta->where('precio', '>=', $minimo))
            ->when($filtros['precio_max'] ?? null, fn ($consulta, $maximo) => $consulta->where('precio', '<=', $maximo))
            ->when($filtros['buscar'] ?? null, fn ($consulta, $texto) => $consulta->where('titulo', 'like', '%' . $texto . '%'));
    }

    // Videojuegos sin ficha de requisitos (relacion 1:1); $incluir mantiene el de la ficha que se esta editando.
    public function scopeSinRequisitos(Builder $query, ?int $incluir = null): Builder
    {
        return $query->where(fn ($consulta) => $consulta
            ->whereDoesntHave('requisitosMinimosPC')
            ->when($incluir, fn ($sub) => $sub->orWhere('id', $incluir)));
    }
}
