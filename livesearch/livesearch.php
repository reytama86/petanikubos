<?php

include("config.php");
if(isset($_POST["input"])){
    $input = $_POST["input"];
    $query = "SELECT * FROM products WHERE nama_barang LIKE '{$input}%'";
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result)> 0){?>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Nama Product</th>
                    <th> Harga </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_array($result)){
                    $name = $row["nama_barang"];
                    $harga = $row["harga"];
                }

                ?>
                <tr>
                    <td><?php echo $name;?></td>
                    <td><?php echo $harga;?></td>
                </tr>
            </tbody>
        </table>

        <?php
    
    }else{
        echo "<h6 class='text-danger text-center mt-3'>No data Found</h6>";
    }
}
?>