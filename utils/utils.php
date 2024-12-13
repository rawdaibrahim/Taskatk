<?php
    function query_result_to_json($result) {
        $json = array();
        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }
        return json_encode($json);
    }
?>