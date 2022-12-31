<?php

if (isset($_POST['Transfer'])) {
    if (isset($_POST['name']) && isset($_POST['email']) &&
        isset($_POST['accno']) && isset($_POST['ifsc']) &&
        isset($_POST['accno_2']) && isset($_POST['amount'])) {

$name=$_POST['name'];
$email=$_POST['email'];
$accno=$_POST['accno'];
$ifsc=$_POST['ifsc'];
$accno_2=$_POST['accno_2'];
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
    $Select = "SELECT email FROM fund WHERE email = ? LIMIT 1";
    $Insert = "INSERT INTO fund(name, email, accno, ifsc, accno_2, amount) values(?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if(ctype_alpha($name))
            {
                if ($rnum == 0) 
            {
                if(ctype_digit($accno) && ctype_digit($accno_2))
                {

                    if(strlen($ifsc)==11)
                    {
                        if(ctype_digit($amount))
                        {
                            $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssssi",$name, $email, $accno, $ifsc, $accno_2 ,$amount,);
                if ($stmt->execute()) {
                    echo "Dear {$name}, funds transferred successfully.";
                }
                else {
                    echo $stmt->error;
                }
                        }
                        else
                        {
                            echo "Dear {$name}, amount must be in integers only.";
                        }
                        
                    }
                    else
                    {
                        echo "Dear {$name}, IFSC code must contain 11 characters only.";
                    }

                    
                }
                else
                {
                    echo "Dear {$name}, account number must contain digits only.";
                }

                
            }
            else {
                echo "Dear {$name}, someone already has made transactions using this email.";
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
    echo "Transfer button is not set";
}
?>