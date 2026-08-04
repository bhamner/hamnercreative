<?php

namespace App\Actions\Auth;

use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SyncSocialiteUser
{
    public function __invoke(SocialiteUser $socialiteUser): User
    {
        $existing = User::withTrashed()
            ->where('vendor_id', $socialiteUser->getId())
            ->first();

        if ($existing) {
            $existing->fill([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'avatar' => $socialiteUser->getAvatar(),
            ]);

            if ($existing->trashed()) {
                $existing->restore();
            } else {
                $existing->save();
            }

            return $existing;
        }

        return User::query()->updateOrCreate(
            ['vendor_id' => $socialiteUser->getId()],
            [
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'avatar' => $socialiteUser->getAvatar(),
            ]
        );
    }
}
