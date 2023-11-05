<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user, $isBackpack = false): void
    {
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        if (! $isBackpack) {
            $user->delete();
        }
    }
}
