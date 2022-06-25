<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract 
{
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'firstname' => $user->userProfile ? $user->userProfile->firstname : 'Unknown',
            'lastname' => $user->userProfile ? $user->userProfile->lastname : 'Unknown',
            'gender' => $user->userProfile ? $user->userProfile->gender : 'Unknown',
        ];
    }
}

