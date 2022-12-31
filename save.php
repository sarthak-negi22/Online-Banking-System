<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['age']) &&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['phone']) && isset($_POST['aadhar']) && 
        isset($_POST['address']) && isset($_POST['income']) &&
        isset($_POST['amount'])) {

$name=$_POST['name'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$aadhar=$_POST['aadhar'];
$address=$_POST['address'];
$income=$_POST['income'];
$amount=$_POST['amount'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "bank";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die('Could not connect to the database.');
}

else {
    $Select = "SELECT email FROM save WHERE email = ? LIMIT 1";
    $Insert = "INSERT INTO save(name, age, gender, email, phone, aadhar,address,income,amount) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if(ctype_alpha($name))
            {
                if($age>=18)
            {
                if(strcmp(strtolower($gender),"male")==0 || strcmp(strtolower($gender),"female")==0 || strcmp(strtolower($gender),"others")==0)
                {
                    if ($rnum == 0) 
                    {
                        if(strlen($phone)==10 && ctype_digit($phone))
                        {
                            if(strlen($aadhar)==12)
                            {
                                if($amount>=5000)
                        {
                        $gender_lower=strtolower($gender);
                        $stmt->close();
                        $stmt = $conn->prepare($Insert);
                        $stmt->bind_param("sisssssii",$name, $age, $gender_lower, $email, $phone ,$aadhar, $address, $income, $amount);
                        if ($stmt->execute()) {
                            echo "Dear {$name}, your details have been submitted successfully.";
                        }
                        else {
                            echo $stmt->error;
                        }
                            
                    }
                    else
                    {
                        echo "Dear {$name}, you can't deposit less than 5000 Rs in the saving account.";
                    }
                            }
                            else
                            {
                                if(!ctype_digit($aadhar))
                                echo "Dear {$name}, Aadhar card number must contain integers only.";

                                else if(strlen($aadhar)<12 || strlen($aadhar)>12)
                                echo "Dear {$name}, Aadhar card number must be of 12 digits only.";
                            }
                        }
                        else
                        {
                            if(!ctype_digit($phone))
                            echo "Dear {$name}, phone number must contain integers only.";

                            else if(strlen($phone)<10)
                            echo "Dear {$name}, phone number must be of 10 digits only.";
                        }

                    }
    
                        
                    else {
                        echo "Dear {$name}, someone has already registered using this email.";
                    }
                }
                else
                {
                    echo "Dear {$name}, you have entered an invalid gender type.";
                }
                
            }
            else
            {
                echo "Dear {$name}, you are underaged. You must be atleast 18 years old to open a saving account.";
            }

            $stmt->close();
            $conn->close();
            }
            else
            {
                echo "Dear user, your name can't contain any digits.";
            }

        }
    }
    else {
        echo "Dear {$name}, all field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>