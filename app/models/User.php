<?php

use Zizaco\Confide\ConfideUser; 
use Zizaco\Confide\ConfideUserInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface { 
    use HasRole;
    use ConfideUser;
}