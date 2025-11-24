<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Assign permissions to role
     */
    public function assignPermissions(array $permissionSlugs): void
    {
        $permissions = Permission::whereIn('slug', $permissionSlugs)->get();
        $this->permissions()->syncWithoutDetaching($permissions->pluck('id'));
    }

    /**
     * Revoke permissions from role
     */
    public function revokePermissions(array $permissionSlugs): void
    {
        $permissions = Permission::whereIn('slug', $permissionSlugs)->get();
        $this->permissions()->detach($permissions->pluck('id'));
    }

    /**
     * Get default role
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }
}
