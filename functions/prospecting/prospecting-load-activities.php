<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$id = $_POST['id'];

$categories = array('LOI', 'ACT_1', 'ACT_2', 'ACT_3', 'ACT');



$sql = $pdo->prepare("SELECT * FROM prospecting_activities WHERE prospect_id = :id AND activity_category = :cat ORDER BY activity_date DESC");


foreach($categories as $key => $cat) {


    $sql->bindParam(":cat", $cat);
    $sql->bindParam(":id", $id);
    $sql->execute();

    if($sql->rowCount()) {

?>

<div class="row">
    <div class="col-12">
        <p class="text-center">
            <button class="btn w100pc pms-red text-white" type="button" data-toggle="collapse" data-target="#<?php echo $cat; ?>" aria-expanded="false" aria-controls="collapseExample"><?php echo renderLang($prospect_activity_arr[$cat]); ?></button>
        </p>
        <div class="collapse" id="<?php echo $cat; ?>">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo renderLang($prospecting_date); ?></th>
                            <th><?php echo renderLang($prospecting_status); ?></th>
                            <?php echo $cat == 'LOI' ? '' : '<th>'.renderLang($prospecting_timeline).'</th>'; ?>
                            <th><?php echo renderLang($prospecting_attachments); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    
<?php  } while ($data = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($data['activity_date'])); ?></td>
                            <td><?php echo $data['activity_status']; ?></td>
                            <?php echo $cat == 'LOI' ? '' : '<td>'.date('Y-m-d', strtotime($data['activity_timeline'])).'</td>'; ?>
                            <td>
                            <?php 
                            if(!empty($data['activity_attachment'])) {

                                $img_ext = array('jpg', 'jpeg', 'png');
                                if(strpos($data['activity_attachment'], ',')) {

                                    $attachments = explode(',', $data['activity_attachment']);
                                    foreach($attachments as $attachment) {

                                        $attachment_part = explode('.', $attachment);
                                        
                                        if(in_array(strtolower($attachment_part[1]), $img_ext)) {

                                            
                                                echo '<a href="/assets/uploads/activities/'.$attachment.'" data-toggle="lightbox">'; 
                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/activities/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                    echo $attachment;
                                                echo '</a><br>';

                                        } else {

                                            echo '<a href="/assets/uploads/activities/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                        }

                                    }

                                } else {

                                    $attachment_part = explode('.', $data['activity_attachment']);
                                    if(in_array(strtolower($attachment_part[1]), $img_ext)) {

                                            
                                        echo '<a href="/assets/uploads/activities/'.$data['activity_attachment'].'" data-toggle="lightbox">'; 
                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/activities/'.$data['activity_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                            echo $data['activity_attachment'];
                                        echo '</a><br>';
                                        

                                    } else {

                                        echo '<a href="/assets/uploads/activities/'.$data['activity_attachment'].'" target="_blank">'.$data['activity_attachment'].'</a><br>';

                                    }
                                
                                }

                            }
                            ?>
                            </td>
                        </tr>

<?php } ?> 
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php } ?>

