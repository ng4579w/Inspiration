<table class="qam">
    <tr>
        <th>No</th>
        <th>Category Name</th>
        <th># Ideas </th>
        <th>Action</th>
    </tr>
    <?php
        $categories=DB::getInstance()->get('category', array('cat_id', '>', 0));
        if(!$categories->count()){
            echo 'There is no category list';
        } else{ 
            $no_c = 0;
        foreach ($categories->results() as $category){ 
                $no_c++;
            $i_no=0;
        $number_of_ideas= DB::getInstance()->get('idea', array('cat_id', '=', $category->cat_id));
        if(!$number_of_ideas->count()){
            $i_no = 0;
        } else {
            foreach ($number_of_ideas->results() as $number_of_idea){
            $i_no++;
            }
        }
    ?>
    <tr>
        <td><?php echo $no_c; ?></td>
        <td><a href="#"><?php  echo $category->cat_name; ?></a></td>
        <td><?php echo $i_no;?></td>
        <td>
            <button class="btn_2"><a href="delete_category.php?cat_page=<?php echo $category->cat_id; ?>">Delete</a></button>            
        </td>
    </tr>
    <?php  }    
    }
    ?>
</table>

