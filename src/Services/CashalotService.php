<?php

namespace Gavan4eg\CashalotApi\Services;

use GuzzleHttp\Client;

class CashalotService
{
    protected string $url = 'https://fsapi.cashalot.org.ua';
    protected $guz;
    protected array $config;

    public function __construct(string $url = null, $guz = null)
    {
        $this->url = $url ?: $this->url;
        $this->guz = $guz ?: new Client();
        $this->config = [
            'NumFiscal' => config('cashalot.numfiscal'),
            'Certificate' => config('cashalot.certificate'),
            'PrivateKey' => config('cashalot.key'),
            'Password' => config('cashalot.password'),
        ];
    }

    /**
     * Request cashalot prro status
     * @return mixed
     */
    public function transactionsRegistrarState()
    {
        return $this->postRequest('TransactionsRegistrarState');
    }

    /**
     * Opening shift in Cashalot
     */
    public function openShift()
    {
        return $this->postRequest('OpenShift');
    }

    /**
     * Closing shift in Cashalot
     * @param bool|null $zrep
     * @return mixed
     */
    public function closeShift(bool $zrep = null)
    {
        return $this->postRequest('CloseShift', null, $zrep);
    }

    /**
     * Creating a check in
     * @param array $check
     * @return mixed
     */
    public function registerCheck(array $check)
    {
        return $this->postRequest('RegisterCheck', $check);
    }

    public function registerZRep()
    {
        return $this->postRequest('RegisterZRep');
    }

    /**
     * Clean
     * @param array $remove
     * @return mixed
     */
    public function cleanUp()
    {
        return $this->postRequest('Cleanup');
    }

    /**
     * Get Object
     * @param array $remove
     * @return mixed
     */
    public function object()
    {
        return $this->postRequest('Objects');
    }


    /**
     * @param string $class
     * @param array|null $check
     * @param bool|null $zrep
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function postRequest(string $class, array $check = null, bool $zrep = null)
    {
        $response = $this->guz->post($this->url,
            ['json' => array_merge(
                ['Command' => $class, 'ZRepAuto' => $zrep],
                $this->config,
                ['Check' => $check]
            )]);
        return $this->statusCode($response);
    }

    /**
     * @param $response
     * @return mixed
     */
    private function decode($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $response
     * @return mixed
     */
    private function statusCode($response)
    {
        return $this->decode($response);
    }
}
