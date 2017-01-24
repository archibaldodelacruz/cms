<?php


class WebTest extends TestCase
{
    /** @test */
    public function it_check_that_web_exists()
    {
        $this->seeInDatabase('webs', [
            'id'        => 1,
            'subdomain' => 'testing',
        ]);
    }
}
