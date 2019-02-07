<?php
echo '<h1>Lista de usuarios</h1>';
foreach($users as $user){
    echo $user->group_id . "|" . $user->name."<br /><hr />";
}
