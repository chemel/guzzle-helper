<?php

namespace Alc\Guzzle;

use Alc\HttpHeaders\HttpHeaders;

class Guzzle
{
    protected $httpHeaders;

    protected $client;

    protected $options = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpHeaders = new HttpHeaders();
        $this->setOptions($this->getDefaultOptions());
        $this->useChrome();
    }

    /**
     * Get default options
     *
     * @return array options
     */
    public function getDefaultOptions()
    {
        $options = array(
            'connect_timeout' => 15,
            'timeout' => 30,
        );

        return $options;
    }

    /**
     * Set options
     *
     * @param array options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Merge options
     *
     * @param array options
     */
    public function mergeOptions($options)
    {
        $this->setOptions($this->getOptions() + $options);
    }

    /**
     * Get options
     *
     * @return array options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get new Client
     *
     * @return Client client
     */
    public function getNewClient()
    {
        $options = $this->getOptions();

        return new \GuzzleHttp\Client($options);
    }

    /**
     * Get Client
     *
     * @return Client client
     */
    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }

        return $this->client = $this->getNewClient();
    }

    /**
     * Reset Client
     *
     * @return Client client
     */
    public function resetClient()
    {
        $this->client = null;
    }

    /**
     * Use HTTP headers
     *
     * @param string name
     */
    public function useHeaders($name)
    {
        $headers = $this->httpHeaders->getHeaders($name);

        $this->mergeOptions(array('headers' => $headers));
    }

    /**
     * Use Chrome HTTP headers
     */
    public function useChrome()
    {
        $headers = $this->httpHeaders->getChrome();

        $this->mergeOptions(array('headers' => $headers));
    }

    /**
     * Use Firefox HTTP headers
     */
    public function useFirefox()
    {
        $headers = $this->httpHeaders->getFirefox();

        $this->mergeOptions(array('headers' => $headers));
    }

    /**
     * Perform GET request
     *
     * @param string url
     * @param array data
     *
     * @return string content
     */
    public function get($url, $data = array())
    {
        $client = $this->getClient();

        return $client->request('GET', $url, array('query' => $data));
    }

    /**
     * Perform POST request
     *
     * @param string url
     * @param array data
     *
     * @return string content
     */
    public function post($url, $data = array())
    {
        $client = $this->getClient();

        return $client->request('POST', $url, array('form_params' => $data));
    }
}
