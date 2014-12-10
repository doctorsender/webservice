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
        $this->url = $url;
        $this->user = $user;
        $this->token = $token;
        $this->proxy = new \SoapClient($this->url, array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
        $header      = new SoapHeader("ns1", "app_auth", array("user" => $this->user, "pass" => $this->token));
        $this->proxy->__setSoapHeaders($header);
    }

   protected function processResponse($response){
     if (!is_array($response) || !isset($response['msg']) || $response['error'] == 1 ) {
       throw new DoctorsenderResponseException($response);
     }
     return $response['msg'];
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
    public function dsCampaignNew($name, $subject, $fromName, $fromEmail, $replyTo, $categoryId, $country, $languageId, $html, $text, $listUnsubscribe = "", $utmCampaign = "", $utmTerm = "", $utmContent = "", $footerDs = True, $mirrorDs = True)
    {
        $results = $this->proxy->webservice('dsCampaignNew', $name, $subject, $fromName, $fromEmail, $replyTo, $categoryId, $country, $languageId, $html, $text, $listUnsubscribe, $utmCampaign, $utmTerm, $utmContent, $footerDs, $mirrorDs);
      return $this->processResponse($results);

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
      return $this->processResponse($results);
    }

  /**
   * Send a campaign to an array of contacts
   *
   * @param $idCampaign
   * @param $contacts    The list of Contact information to be sent. Each contact has to be an associated array with user data. Email field its required.
   * @param $ipGroupName Name of the ipGroup where the campaign will be sent. All ipGroupNames are returned by dsIpGroupGetNames() method.
   * @return mixed
   */
  public function dsCampaignSendEmails(		 	$idCampaign, 	$contacts, 	$ipGroupName )
    {
        $results = $this->proxy->webservice('dsCampaignSendEmails', array($idCampaign, $contacts, $ipGroupName));
      return $this->processResponse($results);
    }

  /**
   * Create a new User List
   *
   * @param      $listName
   * @param      $header
   * @param      $isTestList
   * @param bool $deleteIfExist
   * @return mixed
   */
  public function dsUsersListNew	($listName, $header,  $isTestList,   $deleteIfExist = false  )
  {
    $results = $this->proxy->webservice('dsUsersListNew', array($listName, $header,  $isTestList,   $deleteIfExist));
    return $this->processResponse($results);
  }

  /**
   * Add Users to a List
   *
   * @param $listName
   * @param $data        List of associative arrays with user data. Each user must contain all the indicated values when creating a list
   * @param $isTestList
   * @return mixed
   */
  public function dsUsersListAdd	( 	$listName, $data, $isTestList )
  {
    $results = $this->proxy->webservice('dsUsersListAdd', array($listName, $data, $isTestList ));
    return $this->processResponse($results);
  }



  /**
   * Get all the ipGroup names assigned. A $ipGroupName is required to send a campaign so this method must be called to obtain this parameter.
   *
   * @return mixed
   */
  public function dsIpGroupGetNames(		  )
  {
    $results = $this->proxy->webservice('dsIpGroupGetNames', array());
    return $this->processResponse($results);
  }

  /**
   * Send the campaign to a list. Only one list can be launched with each campaign.
   *
   * @param        $idCampaign
   * @param        $listName
   * @param        $ipGroupName    Name of the ipGroup where the campaign will be sent. All ipGroupNames are returned by dsIpGroupGetNames() method.
   * @param int    $speed
   * @param int    $segmentId
   * @param int    $partitionId
   * @param int    $amount
   * @param bool   $autoDeleteList
   * @param string $programmed
   * @return mixed
   */
public function dsCampaignSendList	(	 	$idCampaign,$listName,$ipGroupName,$speed = 1,$segmentId = 0,$partitionId = 0,$amount = 0,$autoDeleteList = False,$programmed = ""){
  $results = $this->proxy->webservice('dsCampaignSendList', array($idCampaign,$listName,$ipGroupName,$speed,$segmentId,$partitionId,$amount,$autoDeleteList,$programmed));
  return $this->processResponse($results);
}

  /**
   * Send the campaign to a test list.
   *
   * @param $idCampaign  The campaign identifier
   * @param $listName    The name of the test list
   * @return mixed
   */
  public function dsCampaignSendListTest	(	 	$idCampaign,$listName){
    $results = $this->proxy->webservice('dsCampaignSendListTest', array(	$idCampaign,$listName));
    return $this->processResponse($results);
  }

  /**
   * Get the campaign data. You can specify more or less fields to show in response.
   *
   * @param       $idCampaign The campaign identifier
   * @param array $fields     ["name","amount","subject","from_name","from_email","sender","html","text","reply_to","list_unsubscribe","speed","send_date","status","user_list","country","utm_source","utm_medium","utm_term","utm_content","utm_campaign"]
   * @param int   $extraInfo  Add statistic extra info [0: none, 1: statistics, 2: statistics without unique values]
   * @return mixed
   */
  public function dsCampaignGet	(	 	$idCampaign, $fields = array("name", "amount", "subject", "html", "text", "list_unsubscribe", "send_date", "status", "user_list", "country"), $extraInfo = 0 ){
    $results = $this->proxy->webservice('dsCampaignGet', array(		$idCampaign, $fields, $extraInfo));
    return $this->processResponse($results);
  }



} 
