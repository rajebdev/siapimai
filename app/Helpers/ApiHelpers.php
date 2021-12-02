<?php

/**
 * Return a new response from the application.
 * 
 * @see App\Helpers\Apihelpers.php
 * @param  boolean  $success
 * @param  string   $message
 * @param  array    $data
 * @param  int      $status
 * @param  string   $token
 * @param  array    $errors
 * @return \Illuminate\Http\Response
 */
function resp($success, $message, $data, $status, $token = "",  $errors = []){
    return response([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'token' => $token,
        'erros' => $errors
    ], $status);
}