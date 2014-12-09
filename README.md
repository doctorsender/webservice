webservice
==========

Doctorsender webservice to manage campaings, lists, users, etc..

##Install

```
composer require doctorsender/webservice
```

##Configure

Add in your config.yml or import configuration file.

```yml
doctorsender_api:
    user: "username"
    token: "your_api_token"
```

You can override the api endpoint url by adding yourself the key [url]

```yml
doctorsender_api:
    url: http://soapwebservice.doctorsender.com/server.wsdl <-default value
    user: "username"
    token: "your_api_token"
```

##Usage

This bundle provides a service called 'doctorsender' with all necessary method to make api calls to doctorsender.

Controller example:

```php
public function defaultAction(){
    $doctorsender = $this->get('doctorsender');
    $doctorsender->dsCampaignNew(....);
    ...
}
```

You can find extended webservice api info in this link:  [API DOCS](http://soapwebservice.doctorsender.com/doxy/html/index.html)
