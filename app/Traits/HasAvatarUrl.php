<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasAvatarUrl
{
    /**
     * Get the avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        // FIRST: Check if the model has a custom avatar (highest priority)
        if ($this->avatar) {
            return $this->resolveAvatarUrl($this->avatar);
        }

        // SECOND: Check if related USER has an avatar (second priority)
        if (method_exists($this, 'user') && $this->user && $this->user->avatar) {
            return $this->resolveAvatarUrl($this->user->avatar);
        }

        // FINAL: Default fallback
        return $this->getDefaultAvatarUrl();
    }

    /**
     * Resolve the avatar URL from different possible formats.
     *
     * @param string $avatarPath
     * @return string
     */
    protected function resolveAvatarUrl($avatarPath)
    {
        // If it's already a full URL
        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            return $avatarPath;
        }

        // If it's the default avatar string
        if ($avatarPath === 'default-avatar.png') {
            return $this->getDefaultAvatarUrl();
        }

        // If it's a storage path (uploaded avatar)
        if (Storage::disk('public')->exists($avatarPath)) {
            return asset('storage/' . $avatarPath);
        }

        // If it's a relative path without storage prefix
        if (str_starts_with($avatarPath, 'avatars/')) {
            return asset('storage/' . $avatarPath);
        }

        // Try with storage prefix if not exists
        $storagePath = 'avatars/' . basename($avatarPath);
        if (Storage::disk('public')->exists($storagePath)) {
            return asset('storage/' . $storagePath);
        }

        // Fallback to default
        return $this->getDefaultAvatarUrl();
    }

    /**
     * Get the default avatar URL.
     *
     * @return string
     */
    protected function getDefaultAvatarUrl()
    {
        // Option A: Use a static default image
        return asset('images/default-avatar.png');

        // Option B: Use UI Avatars with initials (uncomment if preferred)
        // $name = $this->getAvatarInitials();
        // return "https://ui-avatars.com/api/?name={$name}&color=FFFFFF&background=4F46E5&size=150";
    }

    /**
     * Get initials for avatar.
     *
     * @return string
     */
    protected function getAvatarInitials()
    {
        // Try to get from name attribute
        if (isset($this->name) && !empty($this->name)) {
            $names = explode(' ', $this->name);
            $initials = '';

            foreach ($names as $name) {
                $initials .= strtoupper(substr($name, 0, 1));
                if (strlen($initials) >= 2) break;
            }

            return urlencode($initials);
        }

        // Fallback to model class
        $className = class_basename($this);
        return urlencode(substr($className, 0, 2));
    }

    /**
     * Get avatar HTML for display.
     *
     * @param int $size
     * @param string $classes
     * @return string
     */
    public function getAvatarHtml($size = 48, $classes = '')
    {
        $url = $this->avatar_url;
        $alt = $this->getAvatarAltText();

        return <<<HTML
        <img src="{$url}"
             alt="{$alt}"
             width="{$size}"
             height="{$size}"
             class="rounded-full object-cover {$classes}"
             onerror="this.src='{$this->getDefaultAvatarUrl()}'">
        HTML;
    }

    /**
     * Get alt text for avatar.
     *
     * @return string
     */
    protected function getAvatarAltText()
    {
        if (isset($this->name)) {
            return "Avatar of {$this->name}";
        }

        if (isset($this->full_name)) {
            return "Avatar of {$this->full_name}";
        }

        return "Avatar";
    }
}
