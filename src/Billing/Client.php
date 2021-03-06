<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'billing/';

    /**
     * @return BaseClient
     */
    public function paymentCards()
    {
        return (new PaymentCardClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function recurringCosts()
    {
        return (new RecurringCostClient($this->httpClient))->auth($this->token);
    }
  
    /**
     * @return CloudCostClient
     */
    public function cloudCosts()
    {
        return (new CloudCostClient($this->httpClient))->auth($this->token);
    }
  
    /**
     * @return BaseClient
     */
    public function invoices()
    {
        return (new InvoiceClient($this->httpClient))->auth($this->token);
    }
  
    /**
     * @return BaseClient
     */
    public function invoiceQueries()
    {
        return (new InvoiceQueryClient($this->httpClient))->auth($this->token);
    }
}
