<?php

$event = $_SERVER['HTTP_X_GITHUB_EVENT'];

$repo_path_map = array();
$repo_path_map['martinkuba/testing'] = 'testing';
$repo_path_map['martinkuba/baycentric'] = 'mk';

$request_body = file_get_contents('php://input');
if ($request_body) {
  //write_log($request_body);

  $data = json_decode($request_body);
  $repo_name = $data->repository->full_name;

  if ($event == "ping") {
    write_log("got ping from $repo_name");
  } else if ($event == "push") {
    $path = $repo_path_map[$repo_name];
    $ref = $data->ref;
    write_log("got push event: repo = $repo_name, ref = $ref");
    update_local_repo($path, $ref); 
  }
  if (array_key_exists($repo_name, $repo_path_map)) {

  } else {
    write_log("Unknown repository $repo_name");
  }
}


function update_local_repo($path, $ref) {
  // only update if master was updated
  if ($ref == "refs/heads/master") {
    $command = "git -C $path pull";
    $output = shell_exec("$command 2>&1");
    write_log($output);
  } else {
    write_log("not updating (only if ref is master)");
  }
}

function write_log($data) {
  $time = date(DATE_ISO8601);
  $line = "$time: $data";
  $result = file_put_contents("update-local-repo.log", $line . "\n", FILE_APPEND);
}
