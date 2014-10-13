# [API v3] Mailjet PHP Wrapper

# [SEVERE WARNING] WIP: REVAMPING NOT ACHEVIED #notstable #notuptodate #donotuse

## Introduction

Provides a simple PHP library for the last version of the [MailJet API](http://dev.mailjet.com).
The goal of this component is to simplify the usage of the MailJet API for PHP developers.

### Prerequisites

Make sure to have the following details:
* Mailjet API Key
* Mailjet API Secret Key
* PHP
* This PHP class

## Installation

First clone the repository
```
git clone https://github.com/mailjet/mailjet-apiv3-php-simple.git
```

Go into the mailjet-apiv3-php-simple folder and create an empty file named ```mailjetapi.php```
```
cd mailjet-apiv3-php-simple
touch mailjetapi.php
```

You are now ready to go !

## Usage

First, you need to edit our php-mailjet-v3-simple.class.php file to assign your API keys to the variables ```$apiKey``` and ```$secretKey``` on lines 23 and 24 between simple quotes.
You can find this keys in your Mailjet account here : https://app.mailjet.com/account/api_keys

Then, in your mailjetapi.php file, you need to include our php class :

```php
include("php-mailjet-v3-simple.class.php");
```
**Be Careful :** Make sure that both mailjetapi.php and php-mailjet-v3-simple.class.php files are in the same folder to make this include work

Now you can start working with the mailjetapi.php file by creating a new Mailjet object :
```php
$mj = new Mailjet();
```

This basically starts the engine. Now what you're going to do next depends on what you want to GET, POST, PUT or DELETE from the Mailjet servers through the API.
Take a tour on the [Reference documentation](http://dev.mailjet.com/email-api/v3/apikey/) to see all the resources available.

Next you will specify which resource to call this way (resource Contact in this example) with an array of parameters ```$params``` :
```php
$mj->contact($params);
```
**Info :** If you don't specify the method of the request in the array ```$params``` (see examples below), it will be a GET.

## Examples

### SendAPI

- A function to send an email :
```php
function sendEmail() {
    $mj = new Mailjet();
    $params = array(
        "method" => "POST",
        "from" => "ms.mailjet@example.com",
        "to" => "mr.mailjet@example.com",
        "subject" => "Hello World!",
        "text" => "Greetings from Mailjet."
    );

    $result = $mj->sendEmail($params);

    if ($mj->_response_code == 200)
	   echo "success - email sent";
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to send an email with some attachments (absolute paths on your computer) :
```php
function sendEmailWithAttachments() {
    $mj = new Mailjet();
    $params = array(
        "method" => "POST",
        "from" => "ms.mailjet@example.com",
        "to" => "mr.mailjet@example.com",
        "subject" => "Hello World!",
        "text" => "Greetings from Mailjet.",
        "attachment" => array("@/path/to/first/file.txt", "@/path/to/second/file.txt")
    );

    $result = $mj->sendEmail($params);

    if ($mj->_response_code == 200)
	   echo "success - email sent";
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to send an email with some inline attachments (absolute paths on your computer) :
```php
function sendEmailWithInlineAttachments() {
    $mj = new Mailjet();
    $params = array(
        "method" => "POST",
        "from" => "ms.mailjet@example.com",
        "to" => "mr.mailjet@example.com",
        "subject" => "Hello World!",
        "html" => "<html>Greetings from Mailjet <img src=\"cid:photo1.jpg\"><img src=\"cid:photo2.jpg\"></html>",
	"inlineattachment" => array("@/path/to/photo1.jpg", "@/path/to/photo2.jpg")
    );

    $result = $mj->sendEmail($params);

    if ($mj->_response_code == 200)
	   echo "success - email sent";
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

### Account Settings

- A function to get your profile information :
```php
function viewProfileInfo() {
    $mj = new Mailjet();
    $result = $mj->myprofile();

    if ($mj->_response_code == 200)
       echo "success - got profile information";
    else
       echo "error - ".$mj->_response_code;
}
```

- A function to update the field ```AddressCity``` of your profile :
```php
function updateProfileInfo() {
    $mj = new Mailjet();
    $params = array(
        "method" => "PUT",
        "AddressCity" => "New York"
    );

    $result = $mj->myprofile($params);

    if ($mj->_response_code == 200)
       echo "success - field AddressCity changed";
    else
       echo "error - ".$mj->_response_code;

    return $result;
}
```

### Contact Lists

- A function to print the list of your contacts :
```php
function listContacts()
{
    $mj = new Mailjet();
    $result = $mj->contact();

    if ($mj->_response_code == 200)
	   echo "success - listed contacts";
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to update your contactData resource with ID ```$id```, using arrays :
```php
function updateContactData($id) {
	$mj = new Mailjet();
	$data = array(array('Name' => 'lastname', 'Value' => 'Jet'), array('Name' => 'firstname', 'Value' => 'Mail'));
	$params = array(
		'ID' => $id,
		'Data' => $data,
		'method' => 'PUT'
	);

	$result = $mj->contactdata($params);

	if ($mj->_response_code == 200)
       echo "success - data changed";
    else
       echo "error - ".$mj->_response_code;

	return $result;
}
```

- A function to create a list with name ```$Lname``` :
```php
function createList($Lname) {
    $mj = new Mailjet();
    $params = array(
    	"method" => "POST",
    	"Name" => $Lname
    );

    $result = $mj->contactslist($params);

    if ($mj->_response_code == 201)
	   echo "success - created list ".$Lname;
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to get a list with ID ```$listID``` :
```php
function getList($listID) {
    $mj = new Mailjet();
    $params = array(
    	"method" => "VIEW",
    	"ID" => $listID
    );

    $result = $mj->contactslist($params);

    if ($mj->_response_code == 200)
	   echo "success - got list ".$listID;
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```
Note : You can use unique fields of resources instead of IDs, like
```"unique" => "test@gmail.com"``` in your ```params``` array for this example

- A function to create a contact with email ```$Cemail``` :
```php
function createContact($Cemail) {
    $mj = new Mailjet();
    $params = array(
    	"method" => "POST",
    	"Email" => $Cemail
    );

    $result = $mj->contact($params);

    if ($mj->_response_code == 201)
	   echo "success - created contact ".$Cname;
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to add the contact which ID is ```$contactID``` to the list which ID is ```$listID``` :
```php
function addContactToList($contactID, $listID) {
    $mj = new Mailjet();
    $params = array(
    	"method" => "POST",
    	"ContactID" => $contactID,
    	"ListID" => $listID
    );

    $result = $mj->listrecipient($params);

    if ($mj->_response_code == 201)
	   echo "success - contact ".$contactID." added to the list ".$listID;
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

- A function to delete the list which ID is ```$listID``` :
```php
function deleteList($listID) {
    $mj = new Mailjet();
    $params = array(
    	"method" => "DELETE",
    	"ID" => $listID
    );

    $result = $mj->contactslist($params);

    if ($mj->_response_code == 204)
	   echo "success - deleted list";
    else
	   echo "error - ".$mj->_response_code;

    return $result;
}
```

## Reporting issues

Open an issue on github.
