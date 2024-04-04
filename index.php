<?php
//total array yang disiapkan untuk disimpan
$todos = [];

//melakukan pengecekan apakah file todo.txt ditemukan
if (file_exists('todo.txt')) {

    //membaca file todo.txt
    $file = file_get_contents('todo.txt');

    //mengubah format serialize menjadi array
    $todos = unserialize($file);
}

//jika ditemukan todo yang dikirim melalui method POST
if (isset($_POST['todo'])) {
    $data = $_POST['todo']; //data yang dipilih pada form
    $todos[] = ['todo' => $data, 'status' => 0];
    $daftar_belanja = serialize($todos);
    simpanData($daftar_belanja);
}

//jika ditemukan $_GET['status']
if (isset($_GET['status'])) {

    //ubah status
    $todos[$_GET['key']]['status'] = $_GET['status'];
    $daftar_belanja = serialize($todos);
    simpanData($daftar_belanja);
}

//jika ditemukan perintah hapus
if (isset($_GET['delete'])) {

    //hapus list todo yang dipilih
    unset($todos[$_GET['key']]);
    $daftar_belanja = serialize($todos);
    simpanData($daftar_belanja);
}

function simpanData($daftar_belanja){
    file_put_contents('todo.txt', $daftar_belanja);
    header('location:index.php');
}
?>


<h1>TODO APP by Ferdy Budiono</h1>
<form action="" method="post">
    <label for="">Today Todo List:</label>
    <input type="text" name="todo" id="">
    <button type="submit">Save</button>
</form>

<ul>
    <?php foreach ($todos as $key => $value): ?>
        <li>
            <input onclick="window.location.href='index.php?status=<?php echo ($value['status']==1)? '0': '1'; ?>&key=<?php echo $key;?>';" type="checkbox" name="todo">
            <label>
                <?php
                if ($value['status'] == 1) {
                    echo '<del>'.$value['todo'].'</del>';
                } else {
                    echo $value['todo'];
                }
                ?>
            </label>
            <a href="index.php?delete=1&key=<?php echo $key; ?>" onclick="return confirm('Apakah Anda Yakin akan menghapus data ini?')">Del</a>
        </li>
    <?php endforeach; ?>
</ul>