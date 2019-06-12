<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ezorm');

require_once __DIR__ . "/../vendor/autoload.php";

class customer extends Entity
{
    public $name;

    public $email;

    public $phone;
}

class insurance extends Entity
{

    public $policyNumber;

    public $sumAssured;

    public $customerId;

    public $customer;

    public function __construct()
    {
        $this->customer = new customer();
    }

    static $relations = array(
        "customer" => array('id', 'customerId')
    );
}

// Create
$customer = new customer();
$customer->name = 'Ravi Patel';
$customer->email = 'ravi@rbsoft.org';
$customer->phone = '9999999999';
$ins = new insurance();
$ins->policyNumber = 'ABCD1234';
$ins->sumAssured = 100000;
$ins->customer = $customer;
$ins->save();

// Create
$ins = new insurance();
$ins->policyNumber = 'XYZ12345';
$ins->sumAssured = 200000;
$ins->customerId = 1;
$ins->save();
$ins = new insurance();
$ins->policyNumber = 'XYZ4568';
$ins->sumAssured = 300000;
$ins->customerId = 1;
$ins->save();

// Update Insurance, Create Customer
$ins = new insurance();
$ins->setId(1);
$ins->read();
$ins->policyNumber = "XYZ";
$ins->customerId = null;
$ins->customer->setID(null);
$ins->customer->name = "John Doe";
$ins->customer->email = "example@example.com";
$ins->customer->phone = '1234567890';
$ins->save();

// Read
$insRead2 = new insurance();
$insRead2->setId(1);
$insRead2->read();
print_r($insRead2);
echo "<br/><br/>";

//Delete
$insDelete = new insurance();
$insDelete->setId(1);
$insDelete->delete();

// Read all
$data = insurance::read_all();
print_r($data);
echo "<br/><br/>";

// Update all
insurance::where("insurance.customerId", "1")->update_all(["sumAssured" => 20000]);

// Count
$count = insurance::where("customerId", "1")->count("sumAssured");
echo "Total policy count for customer 1 is {$count}";
echo "<br/><br/>";

// Sum
$sum = insurance::where("customerId", "1")->sum("sumAssured");
echo "Total sumAssured for customer 1 is {$sum}";
echo "<br/><br/>";

// Delete all
insurance::where("insurance.customerId", "1")->delete_all();
$count = insurance::where("customerId", "1")->count("sumAssured");
echo "Total Policy count for cutomer 1 is now {$count}.";