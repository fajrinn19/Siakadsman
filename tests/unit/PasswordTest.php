<?php

use App\Libraries\Password;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class PasswordTest extends CIUnitTestCase
{
    public function testFormatAdminLama(): void
    {
        $lama = hash('sha512', md5('admin123'));

        $this->assertTrue(Password::cocok('admin123', $lama, true));
        $this->assertFalse(Password::cocok('salah', $lama, true));
        $this->assertTrue(Password::perluRehash($lama));
    }

    public function testFormatTeksBiasaLama(): void
    {
        $this->assertTrue(Password::cocok('guru123', 'guru123'));
        $this->assertFalse(Password::cocok('guru12', 'guru123'));
        $this->assertTrue(Password::perluRehash('guru123'));
    }

    public function testHashModern(): void
    {
        $hash = Password::hash('rahasia');

        $this->assertTrue(Password::cocok('rahasia', $hash));
        $this->assertTrue(Password::cocok('rahasia', $hash, true));
        $this->assertFalse(Password::cocok('Rahasia', $hash));
        $this->assertFalse(Password::perluRehash($hash));
    }

    public function testPasswordKosongDitolak(): void
    {
        $this->assertFalse(Password::cocok('', ''));
        $this->assertFalse(Password::cocok('x', null));
    }
}
