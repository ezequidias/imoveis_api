<?php

namespace Tests\Unit\Models;

use App\Models\Property;
use Tests\TestCase;

class PropertyTest extends TestCase
{

    /** @test */
    public function it_gets_the_address()
    {
        $property = new Property;
        $property->address = 'Av. Faria Lima';

        $this->assertEquals(
            'Av. Faria Lima',
            $property->address
        );
    }
}
