<?php
include '../db/db_conn.php';


try {
    $pdo = pdo_init();
    $records = $pdo->query("SELECT * from products ORDER BY id ASC")->fetchAll(PDO::FETCH_OBJ);

    if (count($records) > 0) {
        if (isset($_POST['function'])) {
            $search = $_POST['function'];
    
            foreach ($records as $record) {
                if (strpos($record->name, $search) !== false) { ?>

<tr>
    <td>
        <?php echo $record->id; ?>
    </td>
    <td>
        <?php echo $record->name; ?>
    </td>
    <td>
        <?php echo $record->date; ?>
    </td>
    <td>
        <?php echo $record->supplier; ?>
    </td>
    <td>
        <?php echo $record->quantity; ?>
    </td>
    <td class="text-center">
        <div class="d-flex">
            <a href="#" class="btn btn-outline-secondary btn-sm py-auto mx-1">Edit</a>
            <a href="#" class="btn btn-outline-danger btn-sm mx-1">Delete</a>
        </div>
    </td>
</tr>
<?php
            }
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
