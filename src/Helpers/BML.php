<?php

namespace Jinas\BMLConsole\Helpers;

use Jinas\BMLConsole\Http\Client;

class BML
{
    protected $client;

    public $customerNumber;
    public $gender;
    public $email;
    public $mobileNumber;
    public $status;
    public $idCard;
    public $birthdate;
    public $fullName;

    public $guid;
    public $product;
    public $currency;
    public $account;
    public $alias;
    public $availableBalance;
    public $clearedBalance;
    public $branch;

    public function __construct()
    {
        $this->client = new Client;
    }


    public function login(string $username, string $password): array
    {
        return $this->client->post(['j_username' => $username, 'j_password' => $password], "m/login");
    }

    public function GetDashboardInfo()
    {
        $dashboard = $this->client->get("dashboard")["dashboard"][0];

        $this->guid = $dashboard["id"];
        $this->product = $dashboard["product"];
        $this->currency = $dashboard["currency"];
        $this->account = $dashboard["account"];
        $this->alias = $dashboard["alias"];
        $this->availableBalance = $dashboard["availableBalance"];
        $this->clearedBalance = $dashboard["clearedBalance"];
        $this->branch = $dashboard["branch"];

        return $this;
    }

    public function GetUserInfo()
    {
        $userinfo = $this->client->get("userinfo")["user"];

        $this->customerNumber =  $userinfo["customer_number"];
        $this->gender =  $userinfo["gender"];
        $this->email =  $userinfo["email"];
        $this->mobileNumber =  $userinfo["mobile_phone"];
        $this->status =  $userinfo["status"];
        $this->idCard =  $userinfo["idcard"];
        $this->birthdate =  $userinfo["birthdate"];
        $this->fullName =  $userinfo["fullname"];

        return $this;

    }

    public function GetContacts() : array
    {
        return $this->client->get("contacts");
    }

    public function AddContact(string $accountno, string $alias, string $type = "IAT") : array
    {
        $response = $this->client->post([
            'contact_type' => $type,
            'account' => $accountno,
            'alias' => $alias
        ], "contacts/");
        return $response;
    }

    public function GetTodayTransactions(): array
    {
        return $this->client->get("account/$this->guid/history/today")["history"];
    }

    public function GetPendingTransactions() : array
    {
        return $this->client->get("history/pending/$this->guid");
    }

    public function GetTransactionsBetween(string $from, string $to, string $page = '1'): array
    {
        $from = date('Ymd', strtotime($from));
        $to = date('Ymd', strtotime($to));

        return $this->client->get("account/$this->guid/history/$from/$to/$page")["history"];
    }

    public function GetActivities() : array
    {
        return $this->client->get("activities")["content"]["data"];
    }

}
