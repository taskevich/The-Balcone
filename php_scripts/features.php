<?php
    function files_uploaded(): bool
    {

        // bail if there were no upload forms
        if(empty($_FILES))
            return false;

        // check for uploaded files
        $files = $_FILES['upImage']['tmp_name'];
        foreach( $files as $field_title => $temp_name ){
            if( !empty($temp_name) && is_uploaded_file( $temp_name )){
                // found one!
                return true;
            }
        }
        // return false if no files were found
        return false;
    }