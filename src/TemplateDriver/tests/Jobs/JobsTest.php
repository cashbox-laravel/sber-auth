<?php

namespace Tests\Jobs;

use CashierProvider\Core\Constants\Status;
use CashierProvider\Core\Facades\Config\Payment as PaymentConfig;
use CashierProvider\Core\Services\Jobs;
use DragonCode\Support\Facades\Http\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Fixtures\Models\RequestPayment;
use Tests\TestCase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    protected $model = RequestPayment::class;

    public function testStart()
    {
        $this->assertSame(0, DB::table('payments')->count());
        $this->assertSame(0, DB::table('cashier_details')->count());

        $payment = $this->payment();

        Jobs::make($payment)->start();

        $payment->refresh();

        $this->assertSame(1, DB::table('payments')->count());
        $this->assertSame(1, DB::table('cashier_details')->count());

        $this->assertIsString($payment->cashier->external_id);
        $this->assertMatchesRegularExpression('/^(\d+)$/', $payment->cashier->external_id);

        $this->assertTrue(Url::is($payment->cashier->details->getUrl()));

        $this->assertSame('NEW', $payment->cashier->details->getStatus());

        $this->assertSame(
            PaymentConfig::getStatuses()->getStatus(Status::NEW),
            $payment->status_id
        );
    }

    public function testCheck()
    {
        $this->assertSame(0, DB::table('payments')->count());
        $this->assertSame(0, DB::table('cashier_details')->count());

        $payment = $this->payment();

        Jobs::make($payment)->start();
        Jobs::make($payment)->check(true);

        $payment->refresh();

        $this->assertSame(1, DB::table('payments')->count());
        $this->assertSame(1, DB::table('cashier_details')->count());

        $this->assertIsString($payment->cashier->external_id);
        $this->assertMatchesRegularExpression('/^(\d+)$/', $payment->cashier->external_id);

        $this->assertTrue(Url::is($payment->cashier->details->getUrl()));

        $this->assertSame('NEW', $payment->cashier->details->getStatus());

        $this->assertSame(
            PaymentConfig::getStatuses()->getStatus(Status::NEW),
            $payment->status_id
        );
    }

    public function testRefund()
    {
        $this->assertSame(0, DB::table('payments')->count());
        $this->assertSame(0, DB::table('cashier_details')->count());

        $payment = $this->payment();

        $this->assertSame(
            PaymentConfig::getStatuses()->getStatus(Status::NEW),
            $payment->status_id
        );

        Jobs::make($payment)->start();
        Jobs::make($payment)->refund();

        $payment->refresh();

        $this->assertSame(1, DB::table('payments')->count());
        $this->assertSame(1, DB::table('cashier_details')->count());

        $this->assertIsString($payment->cashier->external_id);
        $this->assertMatchesRegularExpression('/^(\d+)$/', $payment->cashier->external_id);

        $this->assertSame('CANCELED', $payment->cashier->details->getStatus());

        $this->assertSame(
            PaymentConfig::getStatuses()->getStatus(Status::REFUND),
            $payment->status_id
        );
    }
}
