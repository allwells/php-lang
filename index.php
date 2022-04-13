<?php
    require("db_connect.php");

    $get_contacts = 'SELECT * FROM contacts ORDER BY first_name';
    $contact_statement = $db->prepare($get_contacts);
    $contact_statement->execute();

    $contacts = $contact_statement->fetchAll();
    $contact_statement->closeCursor();
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
    <form action="add_contact.php" id="add-contact-form" method="post">
        <input type="text" name="fname" placeholder="First Name" /><br>
        <input type="text" name="lname" placeholder="Last Name" /><br>
        <select name="gender" id="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br>
        <input type="phone" name="phone" placeholder="Phone" /><br>
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