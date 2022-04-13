<?php
    $fname = filter_input(INPUT_POST, 'fname');
    $lname = filter_input(INPUT_POST, 'lname');
    $gender = filter_input(INPUT_POST, 'gender');
    $phone = filter_input(INPUT_POST, 'phone');



    echo "<br>$fname<br>$lname<br>$gender<br>$phone";
    if(empty($fname) || empty($phone)) {

        echo "before set err_msg";
        $err_msg = "All values not entered!";
        require('db_error.php');

        echo "All values not entered";

    } elseif(!preg_match("/[a-zA-Z]{3, 30}$/", $fname)) {
        $err_msg = "Invalid first name!";
        require('db_error.php');

        echo "Invalid First name";

    } elseif(!preg_match("/[a-zA-Z]{3, 30}$/", $lname)) {
        $err_msg = "Invalid last name!";
        require('db_error.php');

        echo "Invalid last name";

    } elseif(!preg_match("/(([0-9]{1})*[- .(]*([0-9]{3})[- .)]*[0-9]{3}[- .)]*[0-9]{4})+$/", $phone)) {
        $err_msg = "Invalid phone number!";
        require('db_error.php');

        echo "Invalid phone";

    } else {


        echo "Else statement block";

        $query = "INSERT INTO `contacts`(`contact_id`, `first_name`, `last_name`, `gender`, `phone`) VALUES (:contact_id, :first_name, :last_name, :gender , :phone)";

        $stm = $db->prepare($query);
        $stm->bindValue(':contact_id', null, PDO::PARAM_INT);
        $stm->bindValue(':first_name', $fname);
        $stm->bindValue(':last_name', $lname);
        $stm->bindValue(':gender', $gender);
        $stm->bindValue(':phone', $phone);

        $execute_success = $stm->execute();
        $stm->closeCursor();

        if(!$execute_success) {
            $err_msg = $stm->errorInfo()[2];
            require('db_error.php');
        }
    }

    require_once('db_connect.php');
    $get_contacts = 'SELECT * FROM contacts ORDER BY first_name';
    $contact_stmt = $db->prepare($get_contacts);
    $contact_stmt->execute();

    $contacts = $contact_stmt->fetchAll();
    $contact_stmt->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php-lang</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css" />
</head>

<body>
    <h1>Phonebook</h1>
    <h3>Add Contact</h3>
    <form action="index.php" id="add-contact-form" method="post">
        <input type="text" name="fname" placeholder="First Name" /><br>
        <input type="text" name="lname" placeholder="Last Name" /><br>
        <select name="gender" id="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>
        <input type="text" name="phone" placeholder="Phone" /><br>
        <input class="submit" type="submit" value="Submit" />
    </form>
    <br>
    <h3>Contact List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Phone</th>
        </tr>

        <?php foreach($contacts as $contact): ?>
        <tr>
            <td><?php echo $contact['contact_id']; ?></td>
            <td><?php echo $contact['first_name'] . " " . $contact['last_name']; ?></td>
            <td><?php echo $contact['gender']; ?></td>
            <td><?php echo $contact['phone']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>