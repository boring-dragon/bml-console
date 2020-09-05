<?php

namespace Jinas\BMLConsole\Helpers;

use Jinas\BMLConsole\Http\Client;

class BML extends Client
{
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


    public function login(string $username, string $password): array
    {
        return $this->PostRequest(['j_username' => $username, 'j_password' => $password], "m/login");
    }

    public function GetDashboardInfo()
    {
        $dashboard = $this->GetRequest("dashboard")["dashboard"][0];

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
        $userinfo = $this->GetRequest("userinfo")["user"];

        $this->customerNumber =  $userinfo["customer_number"];
        $this->gender =  $userinfo["gender"];
        $this->email =  $userinfo["email"];
        $this->mobileNumber =  $userinfo["mobile_phone"];
        $this->status =  $userinfo["status"];
        $this->idCard =  $userinfo["idcard"];
        $this->birthdate =  $userinfo["birthdate"];
        $this->fullName =  $userinfo["fullname"];

    }

    public function GetContacts()
    {
        return $this->GetRequest("contacts");
    }

    public function GetTodayTransactions(): array
    {
        return $this->GetRequest("account/$this->guid/history/today")["history"];
    }

    public function GetPendingTransactions() : array
    {
        return $this->GetRequest("history/pending/$this->guid");
    }

    public function GetTransactionsBetween(string $from, string $to, string $page = '1'): array
    {
        $from = date('Ymd', strtotime($from));
        $to = date('Ymd', strtotime($to));

        return $this->GetRequest("account/$this->guid/history/$from/$to/$page")["history"];
    }

}
