<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['age']) &&
        isset($_POST['gender']) && isset($_POST['email']) &&
        isset($_POST['phone']) && isset($_POST['aadhar']) && 
        isset($_POST['address']) && isset($_POST['income']) &&
        isset($_POST['amount']) && isset($_POST['time'])) {

$name=$_POST['name'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$aadhar=$_POST['aadhar'];
$address=$_POST['address'];
$income=$_POST['income'];
$amount=$_POST['amount'];
$time=$_POST['time'];


$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "bank";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die('Could not connect to the database.');
}

else {
    $Select = "SELECT email FROM loan WHERE email = ? LIMIT 1";
    $Insert = "INSERT INTO loan(name, age, gender, email, phone, aadhar,address,income,amount,time) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
                if(strcmp(strtolower($gender),"male")==0 || strcmp(strtolower($gender),"female")==0  || strcmp(strtolower($gender),"others")==0)
                {
                    if ($rnum == 0) 
                    {
                        if(strlen($phone)==10 && ctype_digit($phone))
                        {
                            if(strlen($aadhar)==12 && ctype_digit($aadhar))
                            {
                                if($amount>=50000 && $amount<=2000000)
                        {
                            $fixed=0.8*$income;
    
                            if($amount<= $fixed)
                            {
                                $temp=$time;
                                if($amount<=100000 && $time<=3)
                                {
                                    $gender_lower=strtolower($gender);
                                    $stmt->close();
                        $stmt = $conn->prepare($Insert);
                        $stmt->bind_param("sisssssiii",$name, $age, $gender_lower, $email, $phone ,$aadhar, $address, $income, $amount, $time);
                        if ($stmt->execute()) {
                            echo "Dear {$name}, your details have been submitted successfully.";
                        }
                        else {
                            echo $stmt->error;
                        }
                                }   
                                else
                                {
                                    if($time>3 && $amount<=100000)
                                    echo "Dear {$name}, the repayment schedule is upto 3 years.";
                                }
                                if($amount<=1000000 && $time<=10 && $amount>100000)
                                {
                                    $stmt->close();
                        $stmt = $conn->prepare($Insert);
                        $stmt->bind_param("sissiisiii",$name, $age, $gender, $email, $phone ,$aadhar, $address, $income, $amount, $time);
                        if ($stmt->execute()) {
                            echo "Dear {$name}, your details have been submitted successfully.";
                        }
                        else {
                            echo $stmt->error;
                        }
                                } 
                                else
                                {
                                    if($time>10 && $amount<=1000000 && $amount>100000)
                                    echo "Dear {$name}, the repayment schedule is upto 10 years.";
                                }
                                if($amount<=2000000 && $time<=15 && $amount>1000000)
                                {
                                    $stmt->close();
                        $stmt = $conn->prepare($Insert);
                        $stmt->bind_param("sissiisiii",$name, $age, $gender, $email, $phone ,$aadhar, $address, $income, $amount, $time);
                        if ($stmt->execute()) {
                            echo "Dear {$name}, your details have been submitted successfully.";
                        }
                        else {
                            echo $stmt->error;
                        }
                                }
                                else
                                {
                                    if($amount<=2000000 && $time>15 && $amount>1000000)
                                    echo "Dear {$name}, the repayment schedule is upto 15 years.";
                                    
                                }
                            }
                            else
                            {
                                if($fixed>=50000)
                                echo "Dear {$name}, you can't loan more than {$fixed} Rs amount as per your annual income";

                                else
                                echo "Dear {$name}, loan criteria is not satisfied as per your annual income.";
                            }
                    }
                    else
                    {
                        echo "Dear {$name}, amount for loan criteria is not satisfied. Kindly update the loan amount.";
                    }
                            }
                            else
                            {
                                if(!ctype_digit($aadhar))
                                echo "Dear {$name}, Aadhar card number must contain integers only.";

                                else if(strlen($aadhar)<12)
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
                echo "Dear {$name}, you are underaged. You must be atleast 18 years old to apply for a loan.";
            }

            $stmt->close();
            $conn->close();
        }
        else
        {
            echo "Dear user, you can't enter digits in your name.";
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