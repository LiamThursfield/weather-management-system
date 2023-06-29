<?php

namespace App\Interfaces;

/**
 * Interface to define core system Permissions
 *
 * When adding a new Permission:
 *      - Add a new const for the permission
 *          - For the name: use the format {ACTION}_{SUBJECT} e.g. VIEW_USERS
 *          - For the value: Use the format {action} {subject} e.g. view users
 *
 *      - Add the permission to the ALL_PERMISSIONS const
 *          - Use the format {subject} => [{action} => {permission constant}] e.g. 'users' => ['view' => self::VIEW_USERS]
 *
 */
class PermissionInterface
{
    // File Manager Permissions
    const EDIT_FILE_MANAGER = 'edit file_manager';
    const VIEW_FILE_MANAGER = 'view file_manager';

    // Profile Permissions
    const EDIT_PROFILE = 'edit profile';
    const VIEW_PROFILE = 'view profile';

    // Telescope Permissions
    const VIEW_TELESCOPE = 'view telescope';

    // User Permissions
    const CREATE_USERS  = 'create users';
    const DELETE_USERS  = 'delete users';
    const EDIT_USERS    = 'edit users';
    const VIEW_USERS    = 'view users';

    // WMS Permissions
    const CREATE_WMS    = 'create wms';
    const DELETE_WMS    = 'delete wms';
    const EDIT_WMS      = 'edit wms';
    const VIEW_WMS      = 'view wms';

    // WMS Admin Permissions
    const CREATE_WMS_ADMIN    = 'create wms_admin';
    const DELETE_WMS_ADMIN    = 'delete wms_admin';
    const EDIT_WMS_ADMIN      = 'edit wms_admin';
    const VIEW_WMS_ADMIN      = 'view wms_admin';


    // All Permissions
    // This is used in User()->all_permissions
    const ALL_PERMISSIONS = [
        'file_manager' => [
            'edit' => self::EDIT_FILE_MANAGER,
            'view' => self::VIEW_FILE_MANAGER,
        ],
        'profile' => [
            'edit' => self::EDIT_PROFILE,
            'view' => self::VIEW_PROFILE,
        ],
        'telescope' => [
            'view'  => self::VIEW_TELESCOPE
        ],
        'users' => [
            'create'    => self::CREATE_USERS,
            'delete'    => self::DELETE_USERS,
            'edit'      => self::EDIT_USERS,
            'view'      => self::VIEW_USERS,
        ],
        'wms' => [
            'create'    => self::CREATE_WMS,
            'delete'    => self::DELETE_WMS,
            'edit'      => self::EDIT_WMS,
            'view'      => self::VIEW_WMS,
        ],
        'wms_admin' => [
            'create'    => self::CREATE_WMS_ADMIN,
            'delete'    => self::DELETE_WMS_ADMIN,
            'edit'      => self::EDIT_WMS_ADMIN,
            'view'      => self::VIEW_WMS_ADMIN,
        ],
    ];

    static function getMiddlewareString($permissions)
    {
        if (is_array($permissions)) {
            $permissions = implode(',', $permissions);
        }

        return 'can:' . $permissions;
    }
}
