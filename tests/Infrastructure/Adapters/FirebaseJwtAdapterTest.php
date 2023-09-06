<?php

namespace Tests\Infrastructure\Adapters;

use App\Domain\Auth\InvalidTokenException;
use App\Domain\User\User;
use App\Infrastructure\Adapters\FirebaseJwtAdapter;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class FirebaseJwtAdapterTest extends TestCase
{
    use UserActionTestHelper;
    private function setAdapter(): FirebaseJwtAdapter
    {
        return new FirebaseJwtAdapter();    
    }   

    public function testEncodeToken()
    {
        $user = $this->createMockUser();
        $adapter = $this->setAdapter();
        $token = $adapter->encodeToken($user);
        
        $this->assertIsString($token);
    }
    
    public function testDecodeToken()
    {
        $adapter = $this->setAdapter();
        $user = $this->createMockUser();
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