<?php 
    require '../vendor/autoload.php';
    include_once 'layouts/header.php';
?>
<?php include_once 'functions.php';?>
<body>
    <?php
    $nameErr = ''; 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["_method"]) && $_POST["_method"] === "put"){
            //PUT REQuEST
            $item_id = $_POST["id"];
            $item_name = $_POST["name"];
            $item->update($item_id , $item_name);
        }elseif(isset($_POST["_method"]) && $_POST["_method"] === "delete"){
             //DELETE REQuEST
             $item_id = $_POST["id"];
             $item->delete($item_id);

        }else{
            //POST REQUEST
            if (empty($_POST["name"])) {
                $nameErr = "Item name cannot be empty ";
            } else {
                $name = test_input($_POST["name"]);
                $item->store($name);
            }
        }
    
    }else if($_SERVER["REQUEST_METHOD"] == "GET") {
        $list_items =  $item->show();
    }
    ?>
    <section class="container">
        <form action="<?= $_SERVER['PHP_SELF'];?>" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4"> Add Item name </label>
                <input type="text" name="name" class="form-control" id="namelist">
                <?php if($nameErr !== ''): ?>
                    <span class="error"> * <?= $nameErr;?></span>
                <?php endif; ?>
                </div>
                <div class="form-group col-md-6" style="margin-top:30px">
                    <button type="submit" class="btn btn-primary"> ADD </button>
                </div>
            </div>
    
        </form>
   </section> 
   <section class="container" id="menu-list">
        <?php if ($list_items->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th class="text-center"> UPDATE </th>
                        <th> DELETE </th>
                    </tr>   
                </thead> 
                <tbody>
                        <?php while($item_row = $list_items->fetch_assoc()) :?>
                            <tr> 
                                <td> <?= $item_row['name'] ?> </td> 
                                <td class="text-center"> 
                                    <form method="post" action="<?= $_SERVER['PHP_SELF'];?>" class="form-row text-center">
                                        <input type="hidden" name="_method" value="put">
                                        <input type="hidden" name="id" value="<?= $item_row['id'] ?>">
                                        <div class="form-group col-md-8">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-success" > UPDATE </button>
                                        </div>
                                    </form>
                                 </td>
                                <td> 
                                    <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="id" value="<?= $item_row['id'] ?>">
                                            <button type="submit" class="btn btn-danger"> DELETE </button>
                                    </form>
                                 </td> 
                            </tr>
                        <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
   </section>
<?php include_once 'layouts/footer.php';?>
