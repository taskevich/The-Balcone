<?php
    function files_uploaded(): bool
    {
        if(empty($_FILES))
            return false;

        $files = $_FILES['upImage']['tmp_name'];
        foreach($files as $field_title => $temp_name) {
            if(!empty($temp_name) && is_uploaded_file($temp_name)) {
                return true;
            }
        }

        return false;
    }