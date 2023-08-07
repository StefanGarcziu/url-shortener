<?php
/**
 * User enum test.
 */

namespace App\Tests\Entity\Enum;

use App\Entity\Enum\UserRole;
use PHPUnit\Framework\TestCase;

/**
 * User enum test.
 */
class UserRoleTest extends TestCase
{
    /**
     * Test user role.
     */
    public function testUserRole()
    {
        self::assertEquals('label.role_user', UserRole::ROLE_USER->label());
    }

    /**
     * Test admin role.
     */
    public function testAdminRole()
    {
        self::assertEquals('label.role_admin', UserRole::ROLE_ADMIN->label());
    }
}