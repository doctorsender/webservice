<?php
namespace Doctorsender\APIBundle\Exceptions;

class DoctorsenderResponseException extends \Exception
{

  public function __construct($response  ) {
    if (!is_array($response) || !isset($response["msg"])) {
      parent::__construct("Response is not a valid format");
    }else{
      parent::__construct($response["msg"]);
    }

  }

}