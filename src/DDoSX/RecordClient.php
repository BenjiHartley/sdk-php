<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Domain;
use UKFast\SDK\DDoSX\Entities\Record;
use UKFast\SDK\SelfResponse;

class RecordClient extends BaseClient
{
    /**
     * @var string $basePath
     */
    protected $basePath = 'ddosx/';

    /**
     * @var array $requestMap
     */
    protected $requestMap = [
        "domain_name" => "domainName",
        "safedns_record_id" => "safednsRecordId",
        "ssl_id" => "sslId"
    ];

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->requestMap);

        $page = $this->paginatedRequest('v1/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($this->apiToFriendly($item, $this->requestMap));
        });

        return $page;
    }

    /**
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPageByDomainName($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->requestMap);

        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($this->apiToFriendly($item, $this->requestMap));
        });

        return $page;
    }

    public function create(Record $record)
    {
        $response = $this->post(
            'v1/domains/' . $record->domainName . '/records',
            json_encode($this->friendlyToApi($record, $this->requestMap))
        );
        $body     = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Record($this->apiToFriendly($body->data, $this->requestMap));
            });
    }

    /**
     * @param Record $record
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Record $record)
    {
        $response = $this->patch(
            'v1/domains/' . $record->domainName . '/records/' . $record->id,
            json_encode($this->friendlyToApi($record, $this->requestMap))
        );
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Domain($this->apiToFriendly($response->data, $this->requestMap));
            });
    }
}
