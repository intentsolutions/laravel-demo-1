<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    const CRUD_PERMISSIONS = ['list', 'show', 'create', 'update', 'delete'];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::factory()->create([
            'group' => 'User',
            'description' => 'Permissions for User entity',
            'permission' => 'login-as',
        ]);

        Permission::factory()->create([
            'group' => 'Media',
            'description' => 'Permissions for Upload Media File',
            'permission' => 'upload-media',
        ]);

        Permission::factory()->create([
            'group' => 'Media',
            'description' => 'Permissions for Destroy Media File',
            'permission' => 'destroy-media',
        ]);

        Permission::factory()->create([
            'group' => 'Lesson',
            'description' => 'Permissions for Lesson list',
            'permission' => 'lessons.list',
        ]);

        Permission::factory()->create([
            'group' => 'Lesson',
            'description' => 'Permissions for Lesson show',
            'permission' => 'lessons.show',
        ]);

        foreach (self::CRUD_PERMISSIONS as $PERMISSION) {
            Permission::factory()->create([
                'group' => 'User',
                'description' => 'Permissions for User entity',
                'permission' => 'admin.users.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Role',
                'description' => 'Permissions for Role entity',
                'permission' => 'admin.roles.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Permission',
                'description' => 'Permissions for Permission entity',
                'permission' => 'admin.permissions.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Categories',
                'description' => 'Permissions for Categories category entity',
                'permission' => 'admin.categories.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Courses',
                'description' => 'Permissions for Courses entity',
                'permission' => 'admin.courses.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Modules',
                'description' => 'Permissions for Modules entity',
                'permission' => 'admin.modules.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Lessons',
                'description' => 'Permissions for Lessons entity',
                'permission' => 'admin.lessons.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Contents',
                'description' => 'Permissions for Contents entity',
                'permission' => 'admin.contents.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Quizzes',
                'description' => 'Permissions for Quizzes entity',
                'permission' => 'admin.quizzes.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Questions',
                'description' => 'Permissions for Questions entity',
                'permission' => 'admin.questions.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Blog-categories',
                'description' => 'Permissions for Blog-categories entity',
                'permission' => 'admin.blog-categories.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Blog-posts',
                'description' => 'Permissions for Blog-posts entity',
                'permission' => 'admin.blog-posts.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Pages',
                'description' => 'Permissions for Pages entity',
                'permission' => 'admin.pages.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Purchases',
                'description' => 'Permissions for Purchases entity',
                'permission' => 'admin.purchases.' . $PERMISSION,
            ]);
            Permission::factory()->create([
                'group' => 'Quiz answers',
                'description' => 'Permissions for quiz answers entity',
                'permission' => 'admin.quiz-answers.' . $PERMISSION,
            ]);
        }

        Permission::factory()->create([
            'group' => 'Settings',
            'description' => 'Permissions for Settings entity',
            'permission' => 'admin.settings.list',
        ]);
        Permission::factory()->create([
            'group' => 'Settings',
            'description' => 'Permissions for Settings entity',
            'permission' => 'admin.settings.create',
        ]);

        $role = Role::factory()->create([
            'name' => 'Admin',
        ]);

        $role->permissions()->sync(Permission::all());

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('demo1234'),
        ]);

        $user->roles()->sync([$role->id]);
    }
}
