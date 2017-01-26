<?php

use App\Models\Finances\Finance;
use App\Policies\FinancePolicy;

class FinancePolicyTest extends TestCase
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new FinancePolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new FinancePolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $finance = factory(Finance::class)->create();

        (new FinancePolicy)->update($this->authUser(), $finance);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $finance = factory(Finance::class)->create();

        (new FinancePolicy)->delete($this->authUser(), $finance);
    }
}
