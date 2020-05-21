<?php 
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$id = $_POST['id'];


$sql = $pdo->prepare("SELECT title FROM other_tasks  WHERE id = :id AND temp_del = 0 LIMIT 1");


    $sql->bindParam(":id", $id);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <p class="text-center">
            <button class="btn w100pc pms-red text-white" type="button" data-toggle="collapse" data-target="#otherTask" aria-expanded="true" aria-controls="collapseExample"><?php echo $data['title']; ?></button>
        </p>
        <div class="collapse show" id="otherTask">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo renderLang($prospecting_date); ?></th>
                            <th><?php echo renderLang($po_other_task_remarks); ?></th>
                            <th><?php echo renderLang($po_other_task_timeline); ?></th>
                            <th><?php echo renderLang($downpayment_attachment); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $sql2 = $pdo->prepare("SELECT date, activity_attachment, timeline, remarks, id FROM  other_task_activities WHERE other_task_id = :other_task_id AND temp_del = 0 ORDER BY id DESC");
                            $sql2->bindParam(":other_task_id", $id);
                            $sql2->execute();
                            while ($data2 = $sql2->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime($data2['date'])); ?></td>
                                    <td><?php echo $data2['remarks']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($data2['timeline'])); ?></td>
                                    <td>
                                    <?php 
                                    if(!empty($data2['activity_attachment'])) {

                                        $img_ext = array('jpg', 'jpeg', 'png');
                                        if(strpos($data2['activity_attachment'], ',')) {

                                            $attachments = explode(',', $data2['activity_attachment']);
                                            foreach($attachments as $attachment) {

                                                $attachment_part = explode('.', $attachment);
                                                
                                                if(in_array(strtolower($attachment_part[1]), $img_ext)) {

                                                    
                                                        echo '<a href="/assets/uploads/other-task-activities/'.$attachment.'" data-toggle="lightbox">'; 
                                                            echo '<img class="has-bg-img mr-2" src="/assets/uploads/other-task-activities/'.$attachment.'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                            echo $attachment;
                                                        echo '</a><br>';

                                                } else {

                                                    echo '<a href="/assets/uploads/other-task-activities/'.$attachment.'" target="_blank">'.$attachment.'</a><br>';

                                                }

                                            }

                                        } else {

                                            $attachment_part = explode('.', $data2['activity_attachment']);
                                            if(in_array(strtolower($attachment_part[1]), $img_ext)) {

                                                    
                                                echo '<a href="/assets/uploads/other-task-activities/'.$data2['activity_attachment'].'" data-toggle="lightbox">'; 
                                                    echo '<img class="has-bg-img mr-2" src="/assets/uploads/other-task-activities/'.$data2['activity_attachment'].'" style="height: 29px; width: 29px;" class="mr-1"></img>';
                                                    echo $data2['activity_attachment'];
                                                echo '</a><br>';
                                                

                                            } else {

                                                echo '<a href="/assets/uploads/other-task-activities/'.$data2['activity_attachment'].'" target="_blank">'.$data2['activity_attachment'].'</a><br>';

                                            }
                                        
                                        }

                                    }
                                    ?>
                                    </td>
                                </tr>

                        <?php }?> 
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

