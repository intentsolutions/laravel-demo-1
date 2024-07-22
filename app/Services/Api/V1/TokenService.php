<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Exceptions\ValidationException;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

final class TokenService
{
    public function __construct(private readonly UserRepository       $userRepository,
                                private readonly PermissionRepository $permissionRepository)
    {
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function create(string $email, string $password, string $deviceName)
    {
        $user = $this->userRepository->getUserByCriteria([
            'email' => $email
        ]);

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        return $user->createToken(
            $deviceName,
            $this->permissionRepository->getPermissionsByUserId($user->id)->pluck('permission')->toArray()
        )->plainTextToken;
    }

    /**
     * @throws Exception
     */
    public function getCurrentUser()
    {
        if (Auth::id()) {
            return $this->userRepository->getUserWithAllRelations(Auth::id());
        }

        return null;
    }

    public function loginAs(int $userId): string
    {
        $user = $this->userRepository->getById($userId);

        $token = $user->createToken(
            'loginAs',
            $this->permissionRepository->getPermissionsByUserId($user->id)->pluck('permission')->toArray(),
            now()->addDay()
        );

        // todo move to repository or trate
        PersonalAccessToken::whereId($token->accessToken->id)->update(['main_user_data' => [
            'main_user_id' => Auth::id(),
            'main_user_device_name' => Auth::user()->currentAccessToken()->name,
        ]]);

        return $token->plainTextToken;
    }

    public function logoutAs(): ?string
    {
        // todo move to repository or trate, associate main_user_data with json in model
        if (Auth::user()->currentAccessToken()->main_user_data) {
            $mainUser = json_decode(Auth::user()->currentAccessToken()->main_user_data);

            if (isset($mainUser->main_user_id) && isset($mainUser->main_user_device_name)) {

                $user = $this->userRepository->getById($mainUser->main_user_id);

                Auth::user()->currentAccessToken()->delete();

                return $user->createToken(
                    $mainUser->main_user_device_name,
                    $this->permissionRepository->getPermissionsByUserId($user->id)->pluck('permission')->toArray()
                )->plainTextToken;
            }
        }

        return null;
    }
}
