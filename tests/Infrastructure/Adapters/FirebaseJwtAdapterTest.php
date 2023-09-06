<?php

namespace Tests\Infrastructure\Adapters;

use App\Domain\Auth\InvalidTokenException;
use App\Domain\User\User;
use App\Infrastructure\Adapters\FirebaseJwtAdapter;
use Tests\TestCase;

class FirebaseJwtAdapterTest extends TestCase
{
    private function setAdapter(): FirebaseJwtAdapter
    {
        return new FirebaseJwtAdapter();    
    }   

    public function testEncodeToken()
    {
        $user = new User(id: 1, username: 'jb', firstName: 'José', lastName: 'Bruno');
        $adapter = $this->setAdapter();
        $token = $adapter->encodeToken($user);
        
        $this->assertIsString($token);
    }
    
    public function testDecodeToken()
    {
        $adapter = $this->setAdapter();
        $user = new User(id: 1, username: 'jb', firstName: 'José', lastName: 'Bruno');
        $token = $adapter->encodeToken($user);
        
        
        $decoded = $adapter->decodeToken($token);
        
        $this->assertArrayHasKey('iat', $decoded);
        $this->assertArrayHasKey('exp', $decoded);
        $this->assertArrayHasKey('id', $decoded);
    }
    
    public function testDecodeInvalidToken()
    {
        $adapter = $this->setAdapter();
        
        $this->expectException(InvalidTokenException::class);
        $adapter->decodeToken('kasdkasd');
    }
}