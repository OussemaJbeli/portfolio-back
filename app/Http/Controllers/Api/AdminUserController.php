<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Back-office account management. Restricted to superadmins.
 */
class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSuperadmin($request);

        return AdminUser::query()->orderBy('name')->get();
    }

    public function show(Request $request, AdminUser $adminUser): AdminUser
    {
        $this->authorizeSuperadmin($request);

        return $adminUser;
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeSuperadmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('admin_users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['superadmin', 'editor'])],
        ]);

        $user = AdminUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function update(Request $request, AdminUser $adminUser): AdminUser
    {
        $this->authorizeSuperadmin($request);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:120'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('admin_users', 'email')->ignore($adminUser)],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', Rule::in(['superadmin', 'editor'])],
        ]);

        if (isset($data['password'])) {
            $data['password_hash'] = Hash::make($data['password']);
            unset($data['password']);
        }

        $adminUser->update($data);

        return $adminUser;
    }

    public function destroy(Request $request, AdminUser $adminUser): Response
    {
        $this->authorizeSuperadmin($request);

        // Don't allow deleting the last superadmin or your own account.
        abort_if($adminUser->is($request->user()), Response::HTTP_CONFLICT, 'You cannot delete your own account.');

        $adminUser->delete();

        return response()->noContent();
    }

    private function authorizeSuperadmin(Request $request): void
    {
        abort_unless(
            $request->user() && $request->user()->isSuperadmin(),
            Response::HTTP_FORBIDDEN,
            'This action requires a superadmin account.'
        );
    }
}
