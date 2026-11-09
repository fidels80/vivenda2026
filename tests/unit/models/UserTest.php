<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = User::findIdentity(100))->notNull();
        verify($user->username)->equals('admin');

        verify(User::findIdentity(999))->null();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = User::findIdentityByAccessToken('100-token'))->notNull();
        verify($user->username)->equals('admin');

        verify(User::findIdentityByAccessToken('non-existing'))->null();
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('admin'))->notNull();
        verify(User::findByUsername('not-admin'))->null();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->true();
        verify($user->validateAuthKey('test102key'))->false();

        verify($user->validatePassword('admin'))->true();
        verify($user->validatePassword('123456'))->false();
    }

}
