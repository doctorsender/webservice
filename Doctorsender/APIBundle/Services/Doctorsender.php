<?php
/**
 * Created by PhpStorm.
 * User: davidpv
 * Date: 9/12/14
 * Time: 12:07
 */

namespace Doctorsender\APIBundle\Services;

use Doctorsender\APIBundle\Exceptions\DoctorsenderResponseException;
class Doctorsender
{

    protected $url, $user, $token, $proxy;

    public function __construct($url, $user, $token)
    {
        $this->proxy = new \SoapClient($this->url, array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
        $header      = new SoapHeader("ns1", "app_auth", array("user" => $this->user, "pass" => $this->token));
        $this->client->__setSoapHeaders($header);
    }

    /**
     * @param      $name
     * @param      $subject
     * @param      $fromName
     * @param      $fromEmail
     * @param      $replyTo
     * @param      $categoryId
     * @param      $country
     * @param      $languageId
     * @param      $html
     * @param      $text
     * @param      $listUnsubscribe
     * @param      $utmCampaign
     * @param      $utmTerm
     * @param      $utmContent
     * @param bool $footerDs
     * @param bool $mirrorDs
     * @return mixed
     * @throws \Exception
     */
    public function dsCampaignNew($name, $subject,
                                  $fromName,
                                  $fromEmail,
                                  $replyTo,
                                  $categoryId,
                                  $country,
                                  $languageId,
                                  $html,
                                  $text,
                                  $listUnsubscribe,
                                  $utmCampaign,
                                  $utmTerm,
                                  $utmContent,
                                  $footerDs = True,
                                  $mirrorDs = True
    )
    {
        $results = $this->proxy->webservice('dsCampaignNew',
            $name,
            $subject,
            $fromName,
            $fromEmail,
            $replyTo,
            $categoryId,
            $country,
            $languageId,
            $html,
            $text,
            $listUnsubscribe,
            $utmCampaign,
            $utmTerm,
            $utmContent,
            $footerDs,
            $mirrorDs);
        if ($results['error'] == 1 || !is_array($results)) {
            throw new DoctorsenderResponseException($results['msg']);
        }

        return $results['msg'];
    }

    /**
     * @param      $campaign_id
     * @param      $html
     * @param bool $track
     * @param bool $returnHtml
     * @return mixed
     * @throws \Exception
     */
    public function dsCampaignUpdate($campaign_id, $html, $track = true, $returnHtml = true)
    {
        $results = $this->proxy->webservice('dsCampaignUpdate', array($campaign_id, $html, stripslashes($html)));
        if ($results['error'] == 1 || !is_array($results)) {
            throw new \Exception($results['msg']);
        }

        return $results['msg'];
    }

    /**
     * @param      $campaign_id
     * @param      $users
     * @param bool $isTest default true
     * @return Mixed
     * @throws \Exception
     */
    public function sendUsers($campaign_id, $users, $isTest = true)
    {
        $results = $this->proxy->webservice('sendUsers', array('campaign_id' => $campaign_id, $users, $isTest));
        if ($results['error'] == 1 || !is_array($results)) {
            throw new \Exception($results['msg']);
        }

        return $results['msg'];
    }

    /**
     * @param       $listName
     * @param array $header
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function createList($listName, array $header, array $data)
    {
        $resultado = $this->proxy->webservice('createList', array($listName, $header, $data, true));
        if ($resultado['error'] == 1 || !is_array($resultado)) {
            throw new \Exception($resultado['msg']);
        }

        return $resultado['msg'];
    }

    /**
     * @param       $listName
     * @param array $data
     * @param bool  $createTable
     * @return mixed
     * @throws \Exception
     */
    public function addUsersToListbyListname($listName, array $data, $createTable = false)
    {
        $resultado = $this->proxy->webservice('addUsersToListbyListname', array($listName, $data, $createTable));
        if ($resultado['error'] == 1 || !is_array($resultado)) {
            throw new \Exception($resultado['msg']);
        }

        return $resultado['msg'];
    }

    /**
     * @param      $listName
     * @param      $rate
     * @param      $idCamp
     * @param int  $isTest
     * @param int  $segmentId
     * @param bool $ab_test
     * @param int  $partitionId
     * @param int  $limit
     * @param bool $autodelete
     * @return mixed
     * @throws \Exception
     */
    public function sendList($listName, $rate, $idCamp, $isTest = 0, $segmentId = 0, $ab_test = false, $partitionId = 0, $limit = 0, $autodelete = false)
    {
        $resultado = $this->proxy->webservice('sendList', array("list_" . $listName, $rate, $idCamp, $isTest, $segmentId, $ab_test, $partitionId, $limit, $autodelete));
        if ($resultado['error'] == 1 || !is_array($resultado)) {
            throw new \Exception($resultado['msg']);
        }

        return $resultado['msg'];
    }

    /**
     * @param $idcampaign
     * @param $truncate
     * @return mixed
     * @throws \Exception
     */
    public function resetCampaign($idcampaign, $truncate)
    {
        $resultado = $this->proxy->webservice('resetCampaign', array($idcampaign, $truncate));
        if ($resultado['error'] == 1 || !is_array($resultado)) {
            throw new \Exception($resultado['msg']);
        }

        return $resultado['msg'];
    }

    /**
     * @param $campaign_id
     * @return mixed
     * @throws \Exception
     */
    public function getResumenStats($campaign_id)
    {
        $results = $this->proxy->webservice('getResumenStats', array('campaign_id' => $campaign_id));
        if ($results['error'] == 1 || !is_array($results)) {
            throw new \Exception($results['msg']);
        }

        return $results['msg'];
    }

} 