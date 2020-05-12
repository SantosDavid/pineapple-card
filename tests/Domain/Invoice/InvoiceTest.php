<?php

namespace Tests\Domain\Invoice;

use Carbon\Carbon;
use DateTime;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Invoice\Exception\InvoiceOpenedCannotBePaidException;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use Tests\Infrastructure\UI\Laravel\TestCase;

class InvoiceTest extends TestCase
{
    public function openedProvider()
    {
        return [
            [10, Carbon::create(2020, 5, 1), Carbon::create(2020, 5, 1)],
            [15, Carbon::create(2020, 4, 15), Carbon::create(2020, 5, 4)],
            [15, Carbon::create(2020, 5, 5), Carbon::create(2020, 5, 5)],
            [15, Carbon::create(2020, 5, 5), Carbon::create(2020, 5, 9)],
            [10, Carbon::create(2020, 4, 25), Carbon::create(2020, 4, 29)],
        ];
    }

    /**
     * @dataProvider openedProvider
     */
    public function testInvoiceShouldBeOpened(int $payDay, DateTime $createdAt, Carbon $now)
    {
        Carbon::setTestNow($now);


        $invoice = new Invoice(new InvoiceId(), new CustomerId(), new PayDay($payDay), $createdAt);


        $this->assertTrue($invoice->isOpened());
    }

    public function closedProvider()
    {
        return [
            [15, Carbon::create(2020, 5, 03), Carbon::create(2020, 5, 16)],
            [5, Carbon::create(2020, 5, 10), Carbon::create(2020, 4, 4)],
            [5, Carbon::create(2020, 5, 10), Carbon::create(2020, 6, 4)],
            [5, Carbon::create(2020, 5, 10), Carbon::create(2019, 6, 4)],
            [5, Carbon::create(2020, 5, 10), Carbon::create(2019, 6, 4)],
        ];
    }

    /**
     * @dataProvider closedProvider
     */
    public function testInvoiceShouldBeClosed(int $payDay, DateTime $createdAt, Carbon $knowDate)
    {
        Carbon::setTestNow($knowDate);


        $invoice = new Invoice(new InvoiceId(), new CustomerId(), new PayDay($payDay), $createdAt);


        $this->assertFalse($invoice->isOpened());
    }

    public function testShouldRaiseExceptionWhenTryingToMarkAsPayedAndInvoiceIsOpened()
    {
        $this->expectException(InvoiceOpenedCannotBePaidException::class);

        $createdAt = Carbon::create(2020, 1, 1);
        Carbon::setTestNow(Carbon::create(2020, 1, 3));


        (new Invoice(new InvoiceId(), new CustomerId(), new PayDay(15), $createdAt))->markAsPayed();
    }
}