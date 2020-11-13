<?php 
require('connectdb.php');
require('poll_db.php');

if (isset($_POST['export'])){

    if ($_POST['export'] == "Export Polls"){
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=polls.csv");
        
        $data = getAllPolls();

        $output = fopen("php://output", "w");
        ob_get_clean();

        fputcsv($output, array("Question", "ID", "Is Active", "Total Votes", "Creator"));
        foreach ($data as $item):
            $row = array($item["question"], $item["poll_id"], $item["is_active"], $item["total_votes"], $item["creator"]);
            fputcsv($output, $row);
        endforeach; 
        fclose($output);
    }
    elseif ($_POST['export'] == "Export Questions"){
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=questions.csv");
        
        $data = getAllQuestions();

        $output = fopen("php://output", "w");
        ob_get_clean();

        fputcsv($output, array("Question", "ID", "Is Active", "Total Responses", "Creator"));
        foreach ($data as $item):
            $row = array($item["question"], $item["question_id"], $item["is_active"], $item["total_responses"], $item["creator"]);
            fputcsv($output, $row);
        endforeach; 
        fclose($output);
    }




}

?>