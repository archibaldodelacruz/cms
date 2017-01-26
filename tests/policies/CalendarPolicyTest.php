<?php

use App\Policies\CalendarPolicy;
use App\Models\Calendar\Calendar;

class CalendarPolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new CalendarPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new CalendarPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $calendar = factory(Calendar::class)->create();

        (new CalendarPolicy)->update($this->authUser(), $calendar);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $calendar = factory(Calendar::class)->create();

        (new CalendarPolicy)->delete($this->authUser(), $calendar);
    }
}
