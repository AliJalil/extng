<?php

function isLoggedIn(): bool
{
    if (isset($_SESSION['extUserId'])) {
        return true;
    } else {
        return false;
    }

}

function checkPermission($permissionsArray, $permissionName): bool
{

//    $permissions = array_column($permissionsArray, 'pName');
    return in_array($permissionName, $permissionsArray);
}
