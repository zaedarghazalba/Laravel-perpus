<?php

namespace App\Policies;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EbookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view published ebooks
        // Admin/staff can view all ebooks
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Ebook $ebook): bool
    {
        // If ebook is published, anyone can view
        if ($ebook->is_published) {
            return true;
        }

        // If not published, only admin/staff can view
        return $user && in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admin and staff can create ebooks
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ebook $ebook): bool
    {
        // Only admin and staff can update ebooks
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ebook $ebook): bool
    {
        // Only admin can delete ebooks
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can read the ebook file.
     */
    public function read(?User $user, Ebook $ebook): bool
    {
        // Must be authenticated to read ebooks
        if (!$user) {
            return false;
        }

        // If published, any authenticated user can read
        if ($ebook->is_published) {
            return true;
        }

        // If not published, only admin/staff can read
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can download the ebook.
     */
    public function download(?User $user, Ebook $ebook): bool
    {
        // Must be authenticated to download ebooks
        if (!$user) {
            return false;
        }

        // If published, any authenticated user can download
        if ($ebook->is_published) {
            return true;
        }

        // If not published, only admin/staff can download
        return in_array($user->role, ['admin', 'staff']);
    }
}
