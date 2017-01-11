<?php

namespace Alc\Guzzle;

use Alc\HttpHeaders\HttpHeaders;

class Guzzle
{
    protected $httpheaders;

    protected $client;

    protected $options = array();

    protected $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpheaders = new HttpHeaders();
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
     * Use HTTP headers
     *
     * @param string name
     */
    public function useHeaders($name)
    {
        $headers = $this->httpheaders->getHeaders($name);

        $this->mergeOptions(array('headers' => $headers));
    }

    /**
     * Use Chrome HTTP headers
     */
    public function useChrome()
    {
        $headers = $this->httpheaders->getChrome();

        $this->mergeOptions(array('headers' => $headers));
    }

    /**
     * Use Firefox HTTP headers
     */
    public function useFirefox()
    {
        $headers = $this->httpheaders->getFirefox();

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

        $this->response =  $client->request('GET', $url, array('query' => $data));

        return $this->response->getBody()->getContents();
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

        $this->response =  $client->request('POST', $url, array('form_params' => $data));

        return $this->response->getBody()->getContents();
    }

    /**
     * Get last response
     *
     * @return Response response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
