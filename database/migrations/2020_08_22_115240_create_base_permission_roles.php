<?php

use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Migration to create the base Permissions and Roles
 *
 * When adding a new Permission:
 *      - Add it to the PermissionInterface class
 *      - Add it to the getNewPermissions() function in this migration
 *      - Add it to any applicable Roles in the getNewRoles() function in this migration
 *
 * When adding a new Role
 *      - Add it to the RoleInterface class
 *      - Add it to the getNewPRoles() function in this migration, along with any Permissions
 *
 */
class CreateBasePermissionRoles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create the new permissions
        foreach ($this->getNewPermissions() as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create the new roles and assign any permissions
        foreach ($this->getNewRoles() as $role_name => $permissions) {
            $role = Role::create(['name' => $role_name]);
            // Assign the permissions to the role
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete the new Permissions and Roles
        Permission::whereIn('name', $this->getNewPermissions())->delete();
        Role::whereIn('name', array_keys($this->getNewRoles()))->delete();
    }


    /**
     * New Permissions being added in the migration
     *
     * @return array
     */
    protected function getNewPermissions()
    {
        return [
            // File Manager
            PermissionInterface::EDIT_FILE_MANAGER,
            PermissionInterface::VIEW_FILE_MANAGER,
            // Profile
            PermissionInterface::EDIT_PROFILE,
            PermissionInterface::VIEW_PROFILE,
            // Telescope
            PermissionInterface::VIEW_TELESCOPE,
            // Users
            PermissionInterface::CREATE_USERS,
            PermissionInterface::DELETE_USERS,
            PermissionInterface::EDIT_USERS,
            PermissionInterface::VIEW_USERS,
            // WMS
            PermissionInterface::CREATE_WMS,
            PermissionInterface::DELETE_WMS,
            PermissionInterface::EDIT_WMS,
            PermissionInterface::VIEW_WMS,
            // WMS Admin
            PermissionInterface::CREATE_WMS_ADMIN,
            PermissionInterface::DELETE_WMS_ADMIN,
            PermissionInterface::EDIT_WMS_ADMIN,
            PermissionInterface::VIEW_WMS_ADMIN,
        ];
    }

    /**
     * New Roles with the associated permissions
     *
     * @return array[]
     */
    protected function getNewRoles()
    {
        return [
            RoleInterface::ADMIN => [
                // File Manager
                PermissionInterface::EDIT_FILE_MANAGER,
                PermissionInterface::VIEW_FILE_MANAGER,
                // Profile
                PermissionInterface::EDIT_PROFILE,
                PermissionInterface::VIEW_PROFILE,
                // Users
                PermissionInterface::CREATE_USERS,
                PermissionInterface::DELETE_USERS,
                PermissionInterface::EDIT_USERS,
                PermissionInterface::VIEW_USERS,
                // WMS
                PermissionInterface::CREATE_WMS,
                PermissionInterface::DELETE_WMS,
                PermissionInterface::EDIT_WMS,
                PermissionInterface::VIEW_WMS,
                // WMS Admin
                PermissionInterface::CREATE_WMS_ADMIN,
                PermissionInterface::DELETE_WMS_ADMIN,
                PermissionInterface::EDIT_WMS_ADMIN,
                PermissionInterface::VIEW_WMS_ADMIN,
            ],
            RoleInterface::SUPER => [],
            RoleInterface::USER => [
                // File Manager
                PermissionInterface::VIEW_FILE_MANAGER,
                // Profile
                PermissionInterface::VIEW_PROFILE,
                // WMS
                PermissionInterface::CREATE_WMS,
                PermissionInterface::DELETE_WMS,
                PermissionInterface::EDIT_WMS,
                PermissionInterface::VIEW_WMS,
            ],
        ];
    }


}
