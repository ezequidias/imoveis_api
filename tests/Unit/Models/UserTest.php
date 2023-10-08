<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function it_gets_the_name()
    {
        $user = new User;
        $user->name = 'Ezequiel';

        $this->assertEquals(
            'Ezequiel',
            $user->name
        );
    }
}
