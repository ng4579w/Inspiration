<?php require_once 'overall/header.php';
error_reporting(E_ERROR);
$checktc  = ( preg_match('/tandc/', $_POST['tandc']) ? 'checked="checked"' : '' );
?>
<div class="main-content"> 
    <div class="main">
        <div class="l_widget">
            <div class="title"> <i class="fa fa-bars" aria-hidden="true"></i> Menu</div>
            <div class="chart" style="text-align: left;">
                <?php require_once 'widgets/l_menu.php';?>
            </div>
        </div> 
        <div class="m_widget">
            <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Use the Form below to post a new idea.</div>
            <div class="chart">
                <form method="post" enctype="multipart/form-data" style=" background-color: #fff;">
                    <div id="errors">
                        <?php require_once 'inc/new_idea_post.inc.php';?>
                    </div>
                    <div>
                        <label style="color: #252A4E">Select a category:</label>
                        <select name="cat_id">
                            <option value = "" style="display: none;"> Select a category</option>
                        <?php $categories=DB::getInstance()->get('category', array('cat_id', '>', 0));
                        if($categories->count()){
                        foreach ($categories->results() as $category){ ?>
                        <option style="color: #000;" value="<?php echo $category->cat_id; ?>" ><?php  echo $category->cat_name; ?></option>
                        <?php  }    
                        }
                        ?>
                    </select>
                    </div>
                    <div>
                        <label style="color: #252A4E">Idea Title:</label>                        
                        <input type="text" name="p_title" autocomplete="off" value="<?php echo Input::get('p_title');?>" placeholder="Idea title" style="border: 1px solid #252A4E;">
                    </div>
                     <div>
                         <label style="color: #252A4E">Select voting closing date:</label><br>                        
                        <input type="date" name="close_date" autocomplete="off" value="<?php echo Input::get('close_date');?>" placeholder="" style="border: 1px solid #252A4E;">
                    </div>
                    <div>
                        <label style="color: #252A4E">Article:</label>
                        <div class="title" >
                            <div class="t_label"> Attach Files:</div>
                            <label for="wordupload"><i class="fa fa-file-word-o"></i></label>
                            <input type="file" name="word_upload" id="wordupload"/>
                            <label for="pdfupload"><i class="fa fa-file-pdf-o"></i></label>
                            <input type="file" name="pdf_upload" id="pdfupload"/>
                            <label for="imageupload"><i class="fa fa-file-picture-o"></i></label>
                            <input type="file" name="image_upload" id="imageupload"/>
                            <span id="uploaded_image"></span>
                            <div class="clear"></div>                             
                        </div>
                        <textarea name="message" placeholder="Maximum 500 words." style="border: 1px solid #252A4E; height: 150px;"><?php echo Input::get('message')?></textarea>
                        <div class="attachment">
                            <?php 
                                if($imageTempName !=""){
                                    echo $imageName;
                                }
                            ?>
                        </div>
                           
                    </div>
                    
                    <input type="checkbox" name="anonymus" id="anonymus"/> 
                    <label for="anonymus" style="color: #252A4E">Post anonymously.</label>
                    <input type="checkbox" name="tandc" id="tandc" value="tandc" <?php echo $checktc; ?>/> 
                    <label for="tandc" style="color: #252A4E">I have read and agree to the<a href="#">Terms & Conditions</a></label>
                    <button class="btn_3" name="post_art" type="submit">Submit Proposal</button>
                    <button class="btn_3" name="clear_form" type="submit" style="background-color: #F7BC2F; color: #252A4E"><a href="new_idea_post.php">Clear Form</a></button>                
                    
                </form>                                
            </div>
        </div>
        <div class="r_widget">
            <div class="title"> <i class="fa fa-th-list" aria-hidden="true"></i> Categories</div>
            <div class="chart">
                <ul>
                    <?php
                        $categories=DB::getInstance()->get('category', array('cat_id', '>', 0));
                        if(!$categories->count()){
                            echo 'There is no category list';
                        } else{                        
                        foreach ($categories->results() as $category){ 
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
                    <li><a href="category_list.php?cat_name=<?php echo $category->cat_id;?>"><?php  echo $category->cat_name . ' (' . $i_no . ')'; ?></a></li>
                    <?php  }    
                    }
                    ?>
                </ul>
            </div>
            <div class="title"><i class="fa fa-window-close-o" aria-hidden="true"></i> Archive</div>
            <div class="chart">
            </div>
        </div>
    </div>
<?php require_once 'overall/footer.php';?>
 

